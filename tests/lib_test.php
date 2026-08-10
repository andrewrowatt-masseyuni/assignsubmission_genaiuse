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

namespace assignsubmission_genaiuse;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/assign/locallib.php');
require_once($CFG->dirroot . '/mod/assign/submission/genaiuse/lib.php');

/**
 * Tests for Generative AI use statement
 *
 * @package    assignsubmission_genaiuse
 * @category   test
 * @copyright  2026 Andrew Rowatt <A.J.Rowatt@massey.ac.nz>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class lib_test extends \advanced_testcase {
    /**
     * Example of a unittest
     *
     * TODO change the 'covers' tag to the class or function in the plugin.
     * @covers ::get_config
     */
    public function test_plugin_installed(): void {
        $this->assertNotEmpty(get_config('assignsubmission_genaiuse', 'version'));
    }

    /**
     * Create a course, an assignment with this plugin enabled, and a student submission.
     *
     * @return array [course, cm, context, student, submission]
     */
    private function setup_submission(): array {
        $this->resetAfterTest();

        $course = $this->getDataGenerator()->create_course();
        $student = $this->getDataGenerator()->create_and_enrol($course, 'student');

        $generator = $this->getDataGenerator()->get_plugin_generator('mod_assign');
        $instance = $generator->create_instance([
            'course' => $course->id,
            'assignsubmission_genaiuse_enabled' => 1,
        ]);

        $cm = get_coursemodule_from_instance('assign', $instance->id, $course->id, false, MUST_EXIST);
        $context = \context_module::instance($cm->id);

        $this->setUser($student);
        $assign = new \assign($context, $cm, $course);
        $submission = $assign->get_user_submission($student->id, true);

        return [$course, $cm, $context, $student, $submission];
    }

    /**
     * Store a file in one of the plugin file areas.
     *
     * @param int $contextid Context to store the file in.
     * @param string $filearea The file area.
     * @param int $itemid The item id, normally the submission id.
     * @param string $filename The file name.
     * @return \stored_file
     */
    private function create_area_file(int $contextid, string $filearea, int $itemid, string $filename): \stored_file {
        return get_file_storage()->create_file_from_string([
            'contextid' => $contextid,
            'component' => 'assignsubmission_genaiuse',
            'filearea' => $filearea,
            'itemid' => $itemid,
            'filepath' => '/',
            'filename' => $filename,
        ], 'Test content for ' . $filearea);
    }

    /**
     * Call the pluginfile callback without writing the file to the test output.
     *
     * Serving a stored file normally echoes its content and terminates the request. Passing
     * 'dontdie' makes send_stored_file() return instead, and echoing the file's content hash
     * back as an If-None-Match header makes readfile_accel() answer "304 Not Modified", so
     * the full success path runs without printing anything.
     *
     * Serving also sets HTTP headers, which PHP cannot do once PHPUnit has written to output,
     * so the resulting warnings are swallowed for the duration of the call. Every other
     * warning is still passed on to the PHPUnit error handler.
     *
     * @param mixed $course Course record, or null.
     * @param mixed $cm Course module record, or null.
     * @param \context $context The context the file is requested from.
     * @param string $filearea The requested file area.
     * @param array $args The remaining URL arguments, starting with the item id.
     * @param \stored_file|null $file The file expected to be served, when one is expected.
     * @return mixed Null when the file was served, false when it was not.
     */
    private function call_pluginfile(
        $course,
        $cm,
        \context $context,
        string $filearea,
        array $args,
        ?\stored_file $file = null
    ) {
        if ($file !== null) {
            $_SERVER['HTTP_IF_NONE_MATCH'] = '"' . $file->get_contenthash() . '"';
        }

        set_error_handler(static function (int $errno, string $errstr): bool {
            // Swallow only the "headers already sent" warnings; let everything else through.
            return strpos($errstr, 'Cannot modify header information') !== false;
        }, E_WARNING);

        $startlevel = ob_get_level();
        ob_start();
        try {
            $result = assignsubmission_genaiuse_pluginfile(
                $course,
                $cm,
                $context,
                $filearea,
                $args,
                true,
                ['dontdie' => true]
            );
        } finally {
            $output = '';
            while (ob_get_level() > $startlevel) {
                $output .= ob_get_clean();
            }
            restore_error_handler();
            unset($_SERVER['HTTP_IF_NONE_MATCH']);
        }

        $this->assertSame('', $output, 'The callback should not have written the file to the test output.');

        return $result;
    }

    /**
     * Tool use files must be served - this file area was missing from the callback whitelist.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_serves_tooluse_file(): void {
        [$course, $cm, $context, , $submission] = $this->setup_submission();
        $file = $this->create_area_file($context->id, 'submission_tooluse', $submission->id, 'tooluse.docx');

        $result = $this->call_pluginfile(
            $course,
            $cm,
            $context,
            'submission_tooluse',
            [$submission->id, 'tooluse.docx'],
            $file
        );

        $this->assertNull($result);
    }

    /**
     * Evidence files must be served.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_serves_evidence_file(): void {
        [$course, $cm, $context, , $submission] = $this->setup_submission();
        $file = $this->create_area_file($context->id, 'submission_evidence', $submission->id, 'evidence.docx');

        $result = $this->call_pluginfile(
            $course,
            $cm,
            $context,
            'submission_evidence',
            [$submission->id, 'evidence.docx'],
            $file
        );

        $this->assertNull($result);
    }

    /**
     * The system wide tool use template must be served to any logged in user.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_serves_template_file(): void {
        $this->resetAfterTest();
        $this->setUser($this->getDataGenerator()->create_user());

        $syscontext = \context_system::instance();
        $file = $this->create_area_file($syscontext->id, 'submission_template', 0, 'template.docx');

        $result = $this->call_pluginfile(
            get_site(),
            null,
            $syscontext,
            'submission_template',
            [0, 'template.docx'],
            $file
        );

        $this->assertNull($result);
    }

    /**
     * A teacher must be able to download another user's tool use file.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_serves_tooluse_file_to_teacher(): void {
        [$course, $cm, $context, , $submission] = $this->setup_submission();
        $file = $this->create_area_file($context->id, 'submission_tooluse', $submission->id, 'tooluse.docx');

        $teacher = $this->getDataGenerator()->create_and_enrol($course, 'editingteacher');
        $this->setUser($teacher);

        $result = $this->call_pluginfile(
            $course,
            $cm,
            $context,
            'submission_tooluse',
            [$submission->id, 'tooluse.docx'],
            $file
        );

        $this->assertNull($result);
    }

    /**
     * File areas that do not belong to this plugin must be rejected.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_rejects_unknown_filearea(): void {
        [$course, $cm, $context, , $submission] = $this->setup_submission();
        $this->create_area_file($context->id, 'submission_bogus', $submission->id, 'bogus.docx');

        $result = $this->call_pluginfile(
            $course,
            $cm,
            $context,
            'submission_bogus',
            [$submission->id, 'bogus.docx']
        );

        $this->assertFalse($result);
    }

    /**
     * A request for a file that does not exist must be rejected.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_rejects_missing_file(): void {
        [$course, $cm, $context, , $submission] = $this->setup_submission();

        $result = $this->call_pluginfile(
            $course,
            $cm,
            $context,
            'submission_tooluse',
            [$submission->id, 'neveruploaded.docx']
        );

        $this->assertFalse($result);
    }

    /**
     * A student must not be able to download another student's tool use file.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_rejects_other_students_submission(): void {
        [$course, $cm, $context, , $submission] = $this->setup_submission();
        $this->create_area_file($context->id, 'submission_tooluse', $submission->id, 'tooluse.docx');

        $otherstudent = $this->getDataGenerator()->create_and_enrol($course, 'student');
        $this->setUser($otherstudent);

        $result = $this->call_pluginfile(
            $course,
            $cm,
            $context,
            'submission_tooluse',
            [$submission->id, 'tooluse.docx']
        );

        $this->assertFalse($result);
    }

    /**
     * Submission files must only be served from a module context.
     *
     * @covers ::assignsubmission_genaiuse_pluginfile
     */
    public function test_pluginfile_rejects_non_module_context(): void {
        [$course, $cm, $context, , $submission] = $this->setup_submission();
        $this->create_area_file($context->id, 'submission_tooluse', $submission->id, 'tooluse.docx');

        $result = $this->call_pluginfile(
            $course,
            $cm,
            \context_course::instance($course->id),
            'submission_tooluse',
            [$submission->id, 'tooluse.docx']
        );

        $this->assertFalse($result);
    }
}
