<?php
class Format {
    static public function arr_to_csv_line($arr) {
        $line = array();
        foreach ($arr as $v) {
            $line[] = is_array($v) ? self::arr_to_csv_line($v) : '"' . str_replace('"', '""', $v) . '"';
        }
        return implode(",", $line);
    }

    static public function arr_to_csv($arr) {
        $lines = array();
        foreach ($arr as $v) {
            $lines[] = self::arr_to_csv_line($v);
        }
        return implode("\n", $lines);
    }
}
?>