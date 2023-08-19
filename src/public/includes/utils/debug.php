<?php
    /**
     * dumps the given variables in a clean readable format
     *
     * @param ...$vars
     */
    function dd(...$vars) {
        $backtrace = debug_backtrace(3, 1)[0];

        foreach ($vars as $var) {
            // inline style because its only needed when we call this function.
            // writing this in scss would be unused style on prod
            echo '<div style="background-color:#f4f4f4;border:2px solid #272726;border-radius:5px;padding:5px 15px;margin:15px;">';
            echo '<p style="background-color:#272726;color:#95b806;padding:5px 15px;margin:-5px -15px 0;">' . $backtrace['file'] . ':' . $backtrace['line'] . '</p>';
            if (is_array($var) || is_object($var)) {
                highlight_string("<?php\n " . var_export($var, true) . "?>");
            } else {
                var_dump($var);
            }
            echo '</div>';
        }
        echo '<script>document.querySelectorAll("code").forEach(function(e){e.getElementsByTagName("span")[1].innerHTML=e.getElementsByTagName("span")[1].innerHTML.replace("&lt;?php", "").replace("<br>", "")}); document.querySelectorAll("code").forEach(function(e){e.getElementsByTagName("span")[e.getElementsByTagName("span").length - 1].remove()}); </script>';
        die(1);
    }