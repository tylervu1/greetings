<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_greetings
 * @copyright   2023 Tyler Vu <tyler.vuvan@nashtechglobal.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 require_once('../../config.php');
 require_once($CFG->libdir . '/formslib.php');
 
 class people_form extends moodleform {
    protected function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'name', get_string('name'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->addRule('name', get_string('required'), 'required', null, 'client');

        $mform->addElement('text', 'email', get_string('email'));
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', get_string('required'), 'required', null, 'client');
        $mform->addRule('email', get_string('invalidemail'), 'email', null, 'client');

        $mform->addElement('text', 'phone', get_string('phone'));
        $mform->setType('phone', PARAM_RAW);
        $mform->addRule('phone', get_string('required'), 'required', null, 'client');
        $mform->addRule('phone', get_string('invalidphone', 'local_greetings'), 'regex', '/^\d{10}$/', 'client');

        $this->add_action_buttons();
    }
}

 $context = context_system::instance();
 $PAGE->set_context($context);
 $PAGE->set_url(new moodle_url('/local/greetings/index.php'));
 $PAGE->set_pagelayout('standard');
 $PAGE->set_title($SITE->fullname);
 $PAGE->set_heading(get_string('pluginname', 'local_greetings'));
 
 echo $OUTPUT->header();
 
 if (isloggedin()) {
     echo '<h3>Greetings, ' . fullname($USER) . '</h3>';
 } else {
     echo '<h3>Greetings, user</h3>';
 }
 
 $mform = new people_form();
 
 if ($mform->is_cancelled()) {
     // Handle form cancel operation, if cancel button is present on form
 } else if ($fromform = $mform->get_data()) {
     // In this case you process validated data. $mform->get_data() returns data posted in form.
     echo "Name: " . $fromform->name . "<br>";
     echo "Email: " . $fromform->email . "<br>";
     echo "Phone: " . $fromform->phone . "<br>";
 } else {
     // This branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
     // or on the first display of the form.
 
     // Set default data (if any)
     $toform = array('name'=>'', 'email'=>'', 'phone'=>'');
     $mform->set_data($toform);
     // Displays the form
     $mform->display();
 }
 
 echo $OUTPUT->footer();
 
