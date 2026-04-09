<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains the moodle hooks for the genaiuse submission plugin.
 *
 * @package    assignsubmission_genaiuse
 * @copyright  2026 Andrew Rowatt <A.J.Rowatt@massey.ac.nz>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Serves assignment submission evidence files.
 *
 * @param mixed $course course or id of the course
 * @param mixed $cm course module or id of the course module
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool false if file not found, does not return if found - just sends the file
 */
function assignsubmission_genaiuse_pluginfile(
    $course,
    $cm,
    context $context,
    $filearea,
    $args,
    $forcedownload,
    array $options = []
) {
    global $DB, $CFG;

    if ($filearea !== 'submission_evidence' && $filearea !== 'submission_template') {
        return false;
    }

    if ($filearea === 'submission_template') {
        // System-wide template file — accessible to any logged-in user.
        require_login();
        $itemid = (int)array_shift($args);
        $relativepath = implode('/', $args);
        $syscontextid = context_system::instance()->id;
        $fullpath = "/{$syscontextid}/assignsubmission_genaiuse/$filearea/$itemid/$relativepath";

        $fs = get_file_storage();
        if (!($file = $fs->get_file_by_hash(sha1($fullpath))) || $file->is_directory()) {
            return false;
        }

        send_stored_file($file, 0, 0, true, $options);
        return;
    }

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_login($course, false, $cm);
    require_once($CFG->dirroot . '/mod/assign/locallib.php');

    $itemid = (int)array_shift($args);
    $record = $DB->get_record(
        'assign_submission',
        ['id' => $itemid],
        'userid, assignment, groupid',
        MUST_EXIST
    );
    $userid = $record->userid;
    $groupid = $record->groupid;

    $assign = new assign($context, $cm, $course);

    if ($assign->get_instance()->id != $record->assignment) {
        return false;
    }

    if (
        $assign->get_instance()->teamsubmission &&
        !$assign->can_view_group_submission($groupid)
    ) {
        return false;
    }

    if (
        !$assign->get_instance()->teamsubmission &&
        !$assign->can_view_submission($userid)
    ) {
        return false;
    }

    $relativepath = implode('/', $args);
    $fullpath = "/{$context->id}/assignsubmission_genaiuse/$filearea/$itemid/$relativepath";

    $fs = get_file_storage();
    if (!($file = $fs->get_file_by_hash(sha1($fullpath))) || $file->is_directory()) {
        return false;
    }

    // Download MUST be forced - security!
    send_stored_file($file, 0, 0, true, $options);
}
