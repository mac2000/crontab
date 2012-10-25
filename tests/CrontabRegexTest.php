<?php
class CrontabRegexTest extends PHPUnit_Framework_TestCase {
    public $re = '/(?P<disabled>#?)\s*(?P<minute>[\*\d\/\-,]+)\s+(?P<hour>[\*\d\/\-,]+)\s+(?P<day>[\*\d\/\-,]+)\s+(?P<month>[\*\d\/\-,]+)\s+(?P<day_of_week>[\*\d\/\-,]+)\s+(?P<command>[^#$]+)#*\s*(?P<name>.*?)$/';

    /**
     * @dataProvider provider
     */
    public function testRegex($str, $disabled, $minute, $hour, $day, $month, $day_of_week, $command, $name)
    {
        preg_match($this->re, $str, $matches);

        $this->assertEquals($disabled, trim($matches['disabled']));
        $this->assertEquals($minute, trim($matches['minute']));
        $this->assertEquals($hour, trim($matches['hour']));
        $this->assertEquals($day, trim($matches['day']));
        $this->assertEquals($month, trim($matches['month']));
        $this->assertEquals($day_of_week, trim($matches['day_of_week']));
        $this->assertEquals($command, trim($matches['command']));
        $this->assertEquals($name, trim($matches['name']));
    }

    public function provider()
    {
        return array(
            array("* * * * * cmd", '', '*', '*', '*', '*', '*', 'cmd', ''),
            array("\t*\t*\t*\t*\t*\tcmd\t", '', '*', '*', '*', '*', '*', 'cmd', ''),
            array("#* * * * * cmd", '#', '*', '*', '*', '*', '*', 'cmd', ''),
            array("# * * * * * cmd", '#', '*', '*', '*', '*', '*', 'cmd', ''),
            array(" # * * * * * cmd", '#', '*', '*', '*', '*', '*', 'cmd', ''),
            array("* * * * * cmd #name", '', '*', '*', '*', '*', '*', 'cmd', 'name'),
            array("# * * * * * cmd # name", '#', '*', '*', '*', '*', '*', 'cmd', 'name'),
            array("#2 * * * * cmd", '#', '2', '*', '*', '*', '*', 'cmd', ''),
            array("# * */2 * * * cmd", '#', '*', '*/2', '*', '*', '*', 'cmd', ''),
            array("* * * 1-5 * cmd #name", '', '*', '*', '*', '1-5', '*', 'cmd', 'name'),
            array("# * * * 1-5/2 * cmd # name", '#', '*', '*', '*', '1-5/2', '*', 'cmd', 'name'),
            array("* * * * 1,2 cmd", '', '*', '*', '*', '*', '1,2', 'cmd', ''),
            array("* * * * * cmd --verbose -u root >> /dev/null 2>&1 #name", '', '*', '*', '*', '*', '*', 'cmd --verbose -u root >> /dev/null 2>&1', 'name'),
            array("* * * * * cmd --verbose -u root >> /dev/null 2>&1 # name", '', '*', '*', '*', '*', '*', 'cmd --verbose -u root >> /dev/null 2>&1', 'name'),
        );
    }
}

//Generate all possible variants
//$spaces = array(" ", "    ", "\t");
//$without_space = array_merge(array(''), $spaces);
//$timings = array(
//    '*', // every
//    '5', // concrete
//    '1,2', // concrete list
//    '1-5', // concrete range
//    '*/2', // every even (0, 2, 4, .., 58)
//    '1,2,3/2', // every even in list (1, 3)
//    '1-5/2' // every even (by index) in range (1, 3, 5)
//);
//$commands = array(
//    'simple',
//    'long --verbose -u root >> /dev/null 2>&1'
//);
//$disabled = array_merge(array(''), array_map(function($space) { return $space . '#'; }, $without_space));
//$names = array_merge(array(''), array_map(function($space){ return '#' . $space . 'name'; }, $without_space));
//
//$variants = array();
//
//foreach ($disabled as $d) {
//    foreach ($spaces as $s1) {
//        foreach ($timings as $minute) {
//            foreach ($spaces as $s2) {
//                foreach ($timings as $hour) {
//                    foreach ($spaces as $s3) {
//                        foreach ($timings as $day) {
//                            foreach ($spaces as $s4) {
//                                foreach ($timings as $month) {
//                                    foreach ($spaces as $s5) {
//                                        foreach ($timings as $day_of_week) {
//                                            foreach ($spaces as $s6) {
//                                                foreach($commands as $command) {
//                                                    foreach ($spaces as $s7) {
//                                                        foreach($names as $name) {
//                                                            $variants[] = array(
//                                                                $d,
//                                                                $s1,
//                                                                $minute,
//                                                                $s2,
//                                                                $hour,
//                                                                $s3,
//                                                                $day,
//                                                                $s4,
//                                                                $month,
//                                                                $s5,
//                                                                $day_of_week,
//                                                                $s6,
//                                                                $command,
//                                                                $s7,
//                                                                $name
//                                                            );
//                                                        }}}}}}}}}}}}}}}
//
//print_r($variants);