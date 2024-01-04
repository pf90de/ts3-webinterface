<?php
if(isset($_SESSION['loggedin'])) {
	if(!isset($_SESSION['vserver_port'])) {
        echo "<div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">";
        echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
        echo "<div>Es wurde kein vServer aus der <a href=\"index.php?site=server\" class=\"alert-link\">Serverliste</a> ausgewählt!</div>";
        echo "</div>";
	} else {
        if($tsAdmin->getElement('success', $tsAdmin->selectServer($_SESSION['vserver_port']))) {

            if($_POST['button_clear_banlist']) {
                if($tsAdmin->getElement('success', $tsAdmin->banDeleteAll())) {
                    echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                    echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
                    echo "Alle Bans wurden erfolgreich gelöscht.";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                    echo "</div>";
                } else {
                    echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                    echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
                    echo "Die Banliste konnte nicht geleert werden.";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                    echo "</div>";
                }                
            }

            if($_POST['button_ban_delete']) {
                if($tsAdmin->getElement('success', $tsAdmin->banDelete($_POST['hidden_banid']))) {
                    echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                    echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
                    echo "Ban (".$_POST['hidden_banid'].") erfolgreich gelöscht.";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                    echo "</div>";
                } else {
                    echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                    echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
                    echo "Ban (ID: ".$_POST['hidden_banid'].") konnte nicht gelöscht werden.";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                    echo "</div>";
                }
            }

            $banList = $tsAdmin->banList();
            ?>

            <div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBanAdd" aria-controls="offcanvasBanAdd">Ban hinzuf&uuml;gen</button></div>
            <div class="d-inline-flex mb-3"><button type="button" class="btn btn-danger" data-bs-toggle="offcanvas" data-bs-target="#offcanvasClearBanList" aria-controls="offcanvasClearBanList">Banliste leeren</button></div>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasBanAdd" aria-labelledby="offcanvasBanAddLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasBanAddLabel"><i class="bi bi-plus-circle-fill"></i> Ban hinzuf&uuml;gen!</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                        tbd...
                    </div>
                    <div class="mt-3">
                        <form method="post" action="index.php?site=banlist" name="form_ban_user" id="form_ban_user">
                            <input type="submit" class="btn btn-success" value="Bannen" name="button_ban_add">
                        </form>
                    </div>
                </div>
            </div>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasClearBanList" aria-labelledby="offcanvasClearBanListLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasClearBanListLabel"><i class="bi bi-exclamation-triangle-fill"></i> Banliste leeren!</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                        Mit Ausf&uuml;hrung des Befehls wird die gesamte Banliste geleert.
                    </div>
                    <div class="mt-3">
                        <form method="post" action="index.php?site=banlist" name="form_clear_banlist" id="form_clear_banlist">
                            <input type="submit" class="btn btn-danger" value="Banliste leeren" name="button_clear_banlist">
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name/IP/UID</th>
                            <th scope="col">erstellt</th>
                            <th scope="col">Dauer</th>
                            <th scope="col">von</th>
                            <th scope="col">Grund</th>
                            <th scope="col" class="text-end">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(empty($banList['data'] )) {
                            echo "<tr>";
                            echo "<td colspan=\"7\">Keine Bans verf&uuml;gbar.</td>";
                            echo "</tr>";
                        } else {
                            foreach($banList['data'] as $ban) {
                                $invokerClientGetNameFromDbid = $tsAdmin->clientGetNameFromDbid($ban['invokercldbid']);
                                echo "<tr>";
                                    echo "<td>".$ban['banid']."</td>";
                                    echo "<td>".$ban['name']."".$ban['ip']."".$ban['uid']."</td>";
                                    echo "<td>".date("d.m.Y - H:i",$ban['created'])."</td>";
                                    echo "<td>";
                                        if($ban['duration'] == 0){
                                            echo "permanent";
                                        } else {
                                            $duration = $tsAdmin->convertSecondsToStrTime($ban['duration']);
                                            echo $duration;
                                        }
                                    echo "</td>";
                                    echo "<td>".$invokerClientGetNameFromDbid['data']['name']."</td>";
                                    echo "<td>".$ban['reason']."</td>";
                                    echo "<td class=\"text-end\"><form method=\"post\" action=\"index.php?site=banlist\" name=\"ban_delete\">
                                    <input type=\"hidden\" name=\"hidden_banid\" value=".$ban['banid'].">
                                    <input type=\"submit\" class=\"btn btn-sm btn-danger\" name=\"button_ban_delete\" value=\"Löschen\">
                                    </form></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <?php
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