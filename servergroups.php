<?php
if(isset($_SESSION['loggedin'])) {
	if(!isset($_SESSION['vserver_port'])) {
        echo "<div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">";
        echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
        echo "<div>Es wurde kein vServer aus der <a href=\"index.php?site=server\" class=\"alert-link\">Serverliste</a> ausgewählt!</div>";
        echo "</div>";
	} else {
        if($tsAdmin->getElement('success', $tsAdmin->selectServer($_SESSION['vserver_port']))) {

            $serverGroupList = $tsAdmin->serverGroupList();

            if($_POST['sgid_rename']) {

            } else {

                ?>

                <div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSGroupAdd" aria-controls="offcanvasSGroupAdd">Gruppe hinzuf&uuml;gen</button></div>

                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">SGID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Typ</th>
                            <th scope="col">DB</th>
                            <th scope="col" class="text-end">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(empty($serverGroupList['data'] )) {
                            echo "<tr>";
                            echo "<td colspan=\"7\">Keine Servergruppen verf&uuml;gbar.</td>";
                            echo "</tr>";
                        } else {
                            foreach($serverGroupList['data'] as $servergroups) {
                                if($servergroups['sgid'] > 5) {
                                    echo "<tr>";
                                        echo "<td>[".$servergroups['sgid']."]</td>";
                                        echo "<td><span class=\"badge bg-dark\">".$servergroups['name']."</span>";
                                            if($tsAdmin->getElement('success', $serverGroupGetIconBySGID = $tsAdmin->serverGroupGetIconBySGID($servergroups['sgid']))) {
                                                echo " <img src=\"data:image/png;base64,".$serverGroupGetIconBySGID['data']."\" />";
                                            }
                                        echo "</td>";
                                        if($servergroups['type'] == 0) {
                                            echo "<td>Template</td>";
                                            echo "<td>".$servergroups['savedb']."</td>";
                                            echo "<td class=\"text-end\">";
                                                echo "<form method=\"post\" action=\"index.php?site=servergroups\" name=\"form_servergroups_edit\">";
                                                        echo "<input type=\"hidden\" name=\"hidden_sgid\" value=".$servergroups['sgid'].">";
                                                echo "</form>";
                                            echo "</td>";
                                        }
                                        if($servergroups['type'] == 1) {
                                            echo "<td>Normal</td>";
                                            echo "<td>".$servergroups['savedb']."</td>";
                                            echo "<td class=\"text-end\">";
                                                echo "<form method=\"post\" action=\"index.php?site=servergroups\" name=\"form_servergroups_edit\">";
                                                    echo "<input type=\"hidden\" name=\"hidden_sgid\" value=".$servergroups['sgid'].">";
                                                    echo "<input type=\"hidden\" name=\"hidden_name\" value=".$servergroups['name'].">";
                                                    echo "<input type=\"submit\" class=\"btn btn-sm btn-primary\" name=\"sgid_rename\" value=\"Umbenennen\">&nbsp;";
                                                    #echo "<button type=\"button\" class=\"btn btn-sm btn-primary\" data-toggle=\"modal\" data-target=\"#clients_".$servergroups['sgid']."\"><i class=\"fas fa-user\"></i> Clients</button>&nbsp;";
                                                    echo "<a href=\"index.php?site=clients&sgid=".$servergroups['sgid']."\" class=\"btn btn-sm btn-info\" role=\"button\">Clients</a>&nbsp;";
                                                    echo "<a href=\"index.php?site=permissions&sgid=".$servergroups['sgid']."\" class=\"btn btn-sm btn-warning\" role=\"button\">Rechte</a>&nbsp;";
                                                    echo "<input type=\"submit\" class=\"btn btn-sm btn-danger\" name=\"button_sgid_delete\" value=\"Löschen\">";
                                                echo "</form>";
                                            echo "</td>";
                                        }
                                        if($servergroups['type'] == 2) {
                                            echo "<td>Query</td>";
                                            echo "<td>".$servergroups['savedb']."</td>";
                                            echo "<td class=\"text-end\">";
                                                echo "<form method=\"post\" action=\"index.php?site=servergroups\" name=\"form_servergroups_edit\">";
                                                    echo "<input type=\"hidden\" name=\"hidden_sgid\" value=".$servergroups['sgid'].">";
                                                echo "</form>";
                                            echo "</td>";
                                        }
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

                <?php
            }

        } else {
            echo "<div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">";
            echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
            echo "<div>Es konnte keine Verbindung zum ausgewählten vServer hergestellt werden!</div>";
            echo "</div>";
        }
    }

} else {
?>
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
            <strong>Zugriff verweigert!</strong> Sie sind nicht eingeloggt.
        </div>
    </div>
<?php
}
?>