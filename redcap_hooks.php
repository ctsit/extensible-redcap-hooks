<?php
###############################################################################
# Copyright 2017 University of Florida. All rights reserved.
# This file was originally part of the redcap-extras project.
# Use of this source code is governed by the license found in the LICENSE file.
###############################################################################

/**
 * REDCap Hooks
 *
 *   Requires PHP >= 5.3.0
 *   Tested with REDCap 6.18.1, 7.2.2.
 *
 * This file enables the file-based management of REDCap Hooks. REDCap supports
 * only one hooks file, specified under Control Center > REDCap Hooks. This
 * file introduces a layer of indirection that allows for multiple
 * implementations per hook. Each hook-function in this file looks for actual
 * hooks in other PHP files with the same name as the hook.
 *
 * For example, if you wanted to add functionality when displaying a data entry
 * form, you would create a "redcap_data_entry_form.php" file, in the same
 * folder as this file, that returns a function with the same paramenters as
 * the `redcap_data_entry_form` hook-function.
 *
 * Additionally, if you wanted to only have a hook enabled for a specifc
 * project, you would put that file under a folder named in the format:
 * "pid{$project_id}", where $project_id is the project's REDCap ID. So, for
 * project 12, create "pid12/redcap_data_entry_form.php".
 *
 * Furthermore, if you have more than one hook, you can create a folder named
 * after the hook, and all PHP files under that folder will be detected. For
 * example:
 *
 *   redcap_data_entry_form/print-disclaimer.php
 *   pid12/redcap_data_entry_form/00-alt-confirm-dialog-hook.php
 *   pid12/redcap_data_entry_form/01-other-hook.php
 *   pid12/redcap_data_entry_form/9-more-stuff.php
 *
 * To activate logging on a specific hook_function, add a TRUE as the third
 * parameter of the call to redcap_hooks_find within that hook_function.  E.g., turn
 *
 *      $hook_files = redcap_hooks_find('redcap_data_entry_form_top', $project_id);
 *
 * into
 *
 *      $hook_files = redcap_hooks_find('redcap_data_entry_form_top', $project_id, TRUE);
 *
 * Hook logging output will be written to `/tmp/hook_events.log` This can be changed by editing
 * the redcap_hooks_find function.  TODO: Make logging activation and the log file configurable.
 *
 *
 * Caveat: Since `redcap_custom_verify_username` has a non-void return type, it
 * is not supported. You'll have to implement the function in this file per the
 * REDCap documentation.
 *
 * @author Taeber Rapczak <taeber@ufl.edu>
 * @copyright Copyright 2017, University of Florida
 * @license See above
 */

/**
 * Finds and runs `redcap_add_edit_records_page` hooks
 * @see REDCap Hooks documentation
 */
function redcap_add_edit_records_page($project_id, $instrument, $event_id)
{
	$hook_files = redcap_hooks_find('redcap_add_edit_records_page', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id, $instrument, $event_id);
	}
}

/**
 * Finds and runs `redcap_control_center` hooks
 * @see REDCap Hooks documentation
 */
function redcap_control_center()
{
	$hook_files = redcap_hooks_find('redcap_control_center');

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook();
	}
}

// CAVEAT: redcap_custom_verify_username is unsupported, but you can still add
// your own function here.

/**
 * Finds and runs `redcap_data_entry_form` hooks
 * @see REDCap Hooks documentation
 */
function redcap_data_entry_form($project_id, $record, $instrument, $event_id,
	$group_id)
{
	$hook_files = redcap_hooks_find('redcap_data_entry_form', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id, $record, $instrument, $event_id, $group_id);
	}
}

/**
 * Finds and runs `redcap_data_entry_form_top` hooks
 * @see REDCap Hooks documentation
 */
function redcap_data_entry_form_top($project_id, $record, $instrument, $event_id,
	$group_id)
{
	$hook_files = redcap_hooks_find('redcap_data_entry_form_top', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id, $record, $instrument, $event_id, $group_id);
	}
}

/**
 * Finds and runs `redcap_every_page_before_render` hooks
 * @see REDCap Hooks documentation
 */
function redcap_every_page_before_render($project_id)
{
	$hook_files = redcap_hooks_find('redcap_every_page_before_render', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id);
	}
}

/**
 * Finds and runs `redcap_every_page_top` hooks
 * @see REDCap Hooks documentation
 */
function redcap_every_page_top($project_id)
{
	$hook_files = redcap_hooks_find('redcap_every_page_top', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id);
	}
}

/**
 * Finds and runs `redcap_project_home_page` hooks
 * @see REDCap Hooks documentation
 */
function redcap_project_home_page($project_id)
{
	$hook_files = redcap_hooks_find('redcap_project_home_page', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id);
	}
}

/**
 * Finds and runs `redcap_save_record` hooks
 * @see REDCap Hooks documentation
 */
function redcap_save_record($project_id, $record, $instrument, $event_id,
	$group_id, $survey_hash, $response_id)
{
	$hook_files = redcap_hooks_find('redcap_save_record', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id, $record, $instrument, $event_id, $group_id,
			$survey_hash, $response_id);
	}
}

/**
 * Finds and runs `redcap_survey_complete` hooks
 * @see REDCap Hooks documentation
 */
function redcap_survey_complete($project_id, $record, $instrument, $event_id,
	$group_id, $survey_hash, $response_id)
{
	$hook_files = redcap_hooks_find('redcap_survey_complete', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id, $record, $instrument, $event_id, $group_id,
			$survey_hash, $response_id);
	}
}

/**
 * Finds and runs `redcap_survey_page` hooks
 * @see REDCap Hooks documentation
 */
function redcap_survey_page($project_id, $record, $instrument, $event_id,
	$group_id, $survey_hash, $response_id)
{
	$hook_files = redcap_hooks_find('redcap_survey_page', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id, $record, $instrument, $event_id, $group_id,
			$survey_hash, $response_id);
	}
}

/**
 * Finds and runs `redcap_survey_page_top` hooks
 * @see REDCap Hooks documentation
 */
function redcap_survey_page_top($project_id, $record, $instrument, $event_id,
	$group_id, $survey_hash, $response_id)
{
	$hook_files = redcap_hooks_find('redcap_survey_page_top', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id, $record, $instrument, $event_id, $group_id,
			$survey_hash, $response_id);
	}
}

/**
 * Finds and runs `redcap_user_rights` hooks
 * @see REDCap Hooks documentation
 */
function redcap_user_rights($project_id)
{
	$hook_files = redcap_hooks_find('redcap_user_rights', $project_id);

	foreach ($hook_files as $filename) {
		$hook = include $filename;
		$hook($project_id);
	}
}

/**
 * Returns filenames matching our file-based, naming convention
 */
function redcap_hooks_find($hook_function, $project_id = '', $logging = FALSE)
{
    $found = array_merge(
        glob(__DIR__ . "/$hook_function.php"),
        glob(__DIR__ . "/$hook_function/*.php"),
        glob(__DIR__ . "/pid$project_id/$hook_function.php"),
        glob(__DIR__ . "/pid$project_id/$hook_function/*.php")
    );

    if ($logging) {
        $log_file = "/tmp/hook_events.log";
        $desired_keys = ['pid', 'page', 'id', 'auto', 'arm', 'pids', 'redcap_csrf_token', 'type', 'action'];
        $my_request = array();
        foreach ($_REQUEST as $key => $value) {
            if (in_array($key,$desired_keys)) {
                $my_request[$key] = $value;
            }
        }

        file_put_contents($log_file, "$hook_function at " . PAGE . " with " . json_encode($my_request) . "\n", FILE_APPEND);
        if (count($found) > 0 ) {
            file_put_contents($log_file, "found hooks: " . print_r($found, TRUE) . "\n", FILE_APPEND);
        }
    }

    return $found;
}
