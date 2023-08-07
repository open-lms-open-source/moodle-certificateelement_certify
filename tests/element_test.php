<?php
// This file is part of the tool_certificate plugin for Moodle - http://moodle.org/
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

namespace certificateelement_certify;

/**
 * Unit tests for certifications element.
 *
 * @group     openlms
 * @package   certificateelement_certify
 * @copyright 2023 Open LMS (https://www.openlms.net/)
 * @author    Petr Skoda
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class element_test extends \advanced_testcase {

    /**
     * Test set up.
     */
    public function setUp(): void {
        $this->resetAfterTest();
    }

    /**
     * Test render_html and pdf generator.
     */
    public function test_render_html() {
        global $CFG;

// TODO: add validity and recertification dates
$this->markTestSkipped('TODO');

        /** @var \tool_certificate_generator $generator */
        $generator = $this->getDataGenerator()->get_plugin_generator('tool_certificate');

        require_once($CFG->dirroot.'/user/profile/lib.php');

        $this->setAdminUser();

        $certificate1 = $generator->create_template((object)['name' => 'Certificate 1']);
        $pageid = $generator->create_page($certificate1)->get_id();

        $element = $generator->create_element($pageid, 'certifications', ['certificationfield' => 'fullname']);
        $this->assertStringContainsString('Certification name', $element->render_html());

        $formdata = (object)['name' => 'Certification id', 'certificationfield' => 'idnumber'];
        $element = $generator->create_element($pageid, 'certifications', $formdata);
        $this->assertStringContainsString('Certification idnumber', $element->render_html());

        $element = $generator->create_element($pageid, 'certifications', ['certificationfield' => 'url']);
        $this->assertStringContainsString('Certification URL', $element->render_html());

        $element = $generator->create_element($pageid, 'certifications', ['certificationfield' => 'timecertified', 'dateformat' => 'strftimedate']);
        $date = userdate(time(), '%d %B %Y');
        $this->assertStringContainsString($date, $element->render_html());

        // Generate PDF for preview.
        $filecontents = $generator->generate_pdf($certificate1, true);
        $filesize = \core_text::strlen($filecontents);
        $this->assertTrue($filesize > 30000 && $filesize < 90000);

        // Generate PDF for issue.
        $user = $this->getDataGenerator()->create_user();
        $issuedata = [
            'certificationid' => '1',
            'certificationfullname' => 'certification 001',
            'certificationidnumber' => 'P001',
            'certificationtimecertified' => time(),
            'certificationallocationid' => '10',
        ];
        $issue = $generator->issue($certificate1, $user, null, $issuedata, 'enrol_certifications');
        $filecontents = $generator->generate_pdf($certificate1, false, $issue);
        $filesize = \core_text::strlen($filecontents);
        $this->assertTrue($filesize > 30000 && $filesize < 90000);

        // Incorrectly manually generated cert.
        $issue = $generator->issue($certificate1, $user);
        $filecontents = $generator->generate_pdf($certificate1, false, $issue);
        $filesize = \core_text::strlen($filecontents);
        $this->assertTrue($filesize > 30000 && $filesize < 90000);
    }
}
