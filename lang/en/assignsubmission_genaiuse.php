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
 * English language pack for Generative AI use statement
 *
 * @package    assignsubmission_genaiuse
 * @category   string
 * @copyright  2026 Andrew Rowatt <A.J.Rowatt@massey.ac.nz>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['ack_confirm'] = 'I have read the acknowledgement above and agree to it.';
$string['ack_required'] = 'You must confirm that you have read the AI use acknowledgement.';
$string['aiuseacknowledgementaiused'] = 'AI Use acknowledgement (AI used)';
$string['aiuseacknowledgementaiused_help'] = 'Acknowledgement content displayed to students on the submission form when they declare that generative AI was used. HTML is supported. Use the {fullname} token to insert the student\'s full name.';
$string['aiuseacknowledgementnoai'] = 'AI Use acknowledgement (no AI used)';
$string['aiuseacknowledgementnoai_help'] = 'Acknowledgement content displayed to students on the submission form when they declare that no generative AI was used. HTML is supported. Use the {fullname} token to insert the student\'s full name.';
$string['aiused'] = 'AI Used';
$string['aiused_helper'] = 'I used generative AI tools or systems to help with this assessment.';
$string['aiusedstatement'] = 'Generative AI was used';
$string['cardstatus_optional'] = 'Choose';
$string['cardstatus_required'] = 'Required';
$string['default'] = 'Enabled by default';
$string['default_help'] = 'If set, this submission method will be enabled by default for all new assignments.';
$string['downloadtemplate'] = 'Download tool use template:';
$string['enabled'] = 'Generative AI use statement';
$string['enabled_help'] = 'If enabled, students must declare whether or not they used generative AI tools in the completion of their submission.';
$string['evidencefiles'] = 'Supporting evidence files';
$string['fieldrequired'] = 'This field is required. Use N/A if this field is not applicable.';
$string['genaiuse_aiuse'] = 'Generative AI use statement - AI Use';
$string['genaiuse_declaration'] = 'Generative AI use statement - Declaration';
$string['maxbytes'] = 'Maximum evidence file size';
$string['maxbytes_help'] = 'The maximum size of each supporting evidence file.';
$string['maxbytesassignsettings'] = 'Generative AI use - Maximum evidence file size';
$string['maxfiles'] = 'Maximum number of evidence files';
$string['maxfiles_help'] = 'The maximum number of supporting evidence files that can be uploaded with the generative AI use statement.';
$string['maxfilesassignsettings'] = 'Generative AI use - Maximum number of evidence files';
$string['noaiused'] = 'No AI Used';
$string['noaiused_helper'] = 'I completed this assessment without using any generative AI tools.';
$string['noaiusedstatement'] = 'No generative AI was used';
$string['onedrive'] = 'Generative AI use statement - OneDrive link';
$string['onedriveassistance'] = 'OneDrive assistance';
$string['onedriveassistance_help'] = 'A URL to a resource for students to guide them through creating a OneDrive link.';
$string['onedriveassistance_link'] = 'How to create a OneDrive link';
$string['onedrivehistoryack'] = 'Require acknowledgement of OneDrive link sharing and history';
$string['onedrivehistoryack_confirm'] = 'I have given this course teacher/tutor/lecturer access to version history of my OneDrive link.';
$string['onedrivehistoryack_help'] = 'When enabled, students who provide a OneDrive link must confirm they have shared the file — including its version history — with the course teacher before they can submit. Only available when "Enable OneDrive link" is set to Yes.';
$string['onedrivehistoryack_required'] = 'You must confirm that you have given access to the version history of your OneDrive link.';
$string['onedrivelink'] = 'Paste in your OneDrive link here';
$string['onedrivelink_choice_label'] = 'Do you have a OneDrive link?';
$string['onedrivelink_choice_required'] = 'Please choose whether you have a OneDrive link to provide.';
$string['onedrivelink_enabled'] = 'Enable OneDrive link';
$string['onedrivelink_enabled_help'] = 'Adds a field to the submission form to capture a OneDrive link to the students submission.';
$string['onedrivelink_enabled_optional'] = 'Yes - optional';
$string['onedrivelink_enabled_required'] = 'Yes - required';
$string['onedrivelink_help'] = 'Paste a OneDrive link to the final copy of your assignment';
$string['onedrivelink_no_disabled'] = 'Disabled as a OneDrive link is required.';
$string['onedrivelink_no_helper'] = 'I have no OneDrive link to provide.';
$string['onedrivelink_no_title'] = 'No OneDrive link supplied';
$string['onedrivelink_required'] = 'A OneDrive link is required for this assignment.';
$string['onedrivelink_yes_helper'] = 'Paste a OneDrive link to the final copy of your assignment.';
$string['onedrivelink_yes_title'] = 'Yes, I have a OneDrive link';
$string['onedrivelinktext'] = 'OneDrive link (opens in new window)';
$string['onedriverecommendation'] = 'OneDrive recommendation';
$string['onedriverecommendation_help'] = 'Recommendation shown to students on the assignment view page when OneDrive link is enabled for an assignment.';
$string['pluginname'] = 'Generative AI use statement';
$string['presubmissioninformation'] = 'Pre-submission information';
$string['presubmissioninformation_help'] = 'Information displayed to students about the generative AI use statement that will be required in order to submit their assignment.';
$string['privacy:metadata:aiused'] = 'Whether generative AI was used in the submission.';
$string['privacy:metadata:assignmentid'] = 'Assignment ID.';
$string['privacy:metadata:evidencechoice'] = 'Whether the student declared they have supporting evidence to upload (yes/no).';
$string['privacy:metadata:filepurpose'] = 'Supporting evidence files for the generative AI use statement.';
$string['privacy:metadata:onedrivelink'] = 'OneDrive link to the final submission, when provided.';
$string['privacy:metadata:onedrivelinkchoice'] = 'Whether the student declared they have a OneDrive link to provide (yes/no).';
$string['privacy:metadata:submissionpurpose'] = 'The submission ID that links to submissions for the user.';
$string['privacy:metadata:tablepurpose'] = 'Stores the generative AI use declaration for each submission.';
$string['privacy:metadata:tooluse'] = 'Detailed description of generative AI tool use entered directly in the submission form.';
$string['privacy:path'] = 'Generative AI Use Statement';
$string['supportingevidence'] = 'Generative AI use statement - Supporting evidence';
$string['supportingevidence_choice_label'] = 'Do you have supporting evidence to upload?';
$string['supportingevidence_choice_required'] = 'Please choose whether you have supporting evidence to upload.';
$string['supportingevidence_no_helper'] = 'I have no additional materials to upload.';
$string['supportingevidence_no_title'] = 'No supporting evidence supplied';
$string['supportingevidence_uploadlabel'] = 'Upload supporting evidence files';
$string['supportingevidence_yes_helper'] = 'Upload screenshots, drafts, version history, and other supporting materials required or recommended by your course coordinator.';
$string['supportingevidence_yes_title'] = 'Yes, I have supporting evidence';
$string['tooluse'] = 'Tool use';
$string['tooluse_add_another'] = 'Add another tool';
$string['tooluse_description'] = 'Use the field to describe in detail the generative AI tools used. Alternatively download the {$a}, edit, and upload to the file area below.';
$string['tooluse_description_notemplate'] = 'Use the field to describe in detail the generative AI tools used.';
$string['tooluse_heading'] = 'Generative AI use statement - Tool use';
$string['tooluse_method_label'] = 'For each tool you used, provide details of your prompts, outputs, and how you used them';
$string['tooluse_method_required'] = 'Please choose how you will provide tool use details.';
$string['tooluse_method_text_helper'] = 'Use this option if you only have text to provide, such as prompts and outputs.';
$string['tooluse_method_text_title'] = 'Enter text';
$string['tooluse_method_upload_helper'] = 'Use this option if you also have screenshots, annotated documents, or other non-text materials to provide as evidence.';
$string['tooluse_method_upload_title'] = 'Upload document';
$string['tooluse_template_link'] = 'Microsoft Word template';
$string['tooluse_text_required'] = 'Please enter tool use details.';
$string['tooluse_upload_required'] = 'Please upload at least one tool use document.';
$string['tooluse_upload_text'] = 'Download the {$a}, complete each section for every tool you used, then upload the completed file below.';
$string['toolusetemplate'] = 'Tool use template';
$string['toolusetemplate_help'] = 'Upload an optional Word document template that students can download when completing their generative AI use statement.';
$string['toolusetemplatecontent'] = 'Tool use template text';
$string['toolusetemplatecontent_help'] = 'Optional richtext content pre-filled into the Tool use field on the submission form. Leave blank to start with an empty field.';
