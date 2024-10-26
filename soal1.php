<?php

$jml = $_GET['jml'] ?? ''; // added null handler
echo "<table border=1 style='border-collapse: collapse;'>\n"; // added border collapse styling
for ($a = $jml; $a > 0; $a--) {
    echo "<tr><td colspan='$jml'>TOTAL : $a</td></tr>"; // added cols total each rows
    echo "<tr>\n";
    for ($b = $a; $b > 0; $b--) {
        echo "<td>$b</td>";
    }
    echo "</tr>\n";
}
echo "</table>";
