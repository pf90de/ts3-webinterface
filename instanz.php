<?php
if(isset($_SESSION['loggedin'])) {

    if($_POST['button_shutdown'] || $_POST['button_newpassword']) {
        if($_POST['button_shutdown']) {
            if($tsAdmin->getElement('success', $tsAdmin->serverProcessStop())) {
                ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            Die Instanz wurde erfolgreich heruntergefahren und der Prozess gestoppt.
                        </div>
                    </div>
                <?php
                header("refresh:3;url=index.php?site=logout");
            } else {
                ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Die Instanz konnte nicht heruntergefahren werden.
                        </div>
                    </div>
                <?php
                header("refresh:3;url=index.php?site=instanz");
            }
        }
        if($_POST['button_newpassword']) {
			if(filter_var($_POST['email-newpassword'], FILTER_VALIDATE_EMAIL)) {
				if($tsAdmin->getElement('success', $output = $tsAdmin->clientSetServerQueryLogin($_SESSION['username']))) {
					$to = $_POST['email-newpassword'];
					$subject = "Teamspeak 3 Server: Neues Admin Passwort via netzhost24.de Webinterface";
					$headers = "From: noreply@netzhost24.de\r\n";
					$headers .= "Replay-To: teamspeak@netzhost24.de\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    $message = "<html><body>";
                    $message .= "<div style=\"font-family: Arial, Helvetica, sans-serif;\">";
                    $message .= "<img src=\"https://ts.netzhost24.de/images/header/motd_2015_clear_back.png\" alt=\"Header\"><br>";
                    $message .= "Hallo ".$_SESSION['username'].",<br><br>";
                    $message .= "dein neues Passwort lautet: ".$output['data']['client_login_password']."<br><br>";
                    $message .= "Vielen Dank für die Nutzung des <a href=\"https://ts.netzhost24.de\" target=\"_blank\">Teamspeak Webinterfaces</a> von netzhost24.de.<br><br>";
                    $message .= "Mit freundlichen Grüßen<br>";
                    $message .= "<a href=\"https://www.netzhost24.de\" target=\"_blank\">netzhost24.de</a><br><br>";
                    $message .= "<small>Diese Email wurde automatisch generiert. Es kann darauf nicht geantwortet werden.</small>";
                    $message .= "</div>";
                    $message .= "</body></html>";
					if(mail($to, $subject, $message, $headers)) {
						echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
						echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
						echo "Email erfolgreich gesendet.<br>Das neue Passwort für ".$_SESSION['username']." lautet: ".$output['data']['client_login_password']."";
                        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
						echo "</div>";
					} else {
						echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
						echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
						echo "Email konnte nicht gesendet werden. Das neue Passwort für ".$_SESSION['username']." lautet: ".$output['data']['client_login_password']."";
                        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
						echo "</div>";
					}
					//header("refresh:10;url=index.php?site=logout");

				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Es konnte kein neues Passwort generiert werden.";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
					//header("refresh:3;url=index.php?site=instanz");
				}
			} else {
				echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
				echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
				echo "Die eingegebene Email Adresse ist nicht korrekt. Es konnte kein neues Passwort generiert und verschickt werden.";
                echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
				echo "</div>";
				//header("refresh:3;url=index.php?site=instanz");
			}
        }
    } else {

        $hostinfo = $tsAdmin->hostInfo();
        $instanceinfo = $tsAdmin->instanceInfo();
        $serverGroupList = $tsAdmin->serverGroupList();
    ?>

        <div class="d-inline-flex"><button type="button" class="btn btn-danger" data-bs-toggle="offcanvas" data-bs-target="#offcanvasShutdown" aria-controls="offcanvasShutdown">Instanz herunterfahren</button></div>
        <div class="d-inline-flex"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNewPassword" aria-controls="offcanvasNewPassword">Neues Admin Passwort</button></div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasShutdown" aria-labelledby="offcanvasShutdownLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasShutdownLabel"><i class="bi bi-exclamation-triangle-fill"></i> ACHTUNG!</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    Mit Ausf&uuml;hrung des Befehls wird die gesamte Instanz heruntergefahren und der Prozess gestoppt. Ein erneutes Starten der Instanz ist nur manuell m&ouml;glich.
                </div>
                <div class="mt-3">
                    <form method="post" action="index.php?site=instanz" name="form_shutdown" id="form_shutdown">
                        <input type="submit" class="btn btn-danger" value="Instanz herunterfahren" name="button_shutdown">
                    </form>
                </div>
            </div>
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNewPassword" aria-labelledby="offcanvasNewPasswordLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNewPasswordLabel"><i class="bi bi-exclamation-triangle-fill"></i> ACHTUNG!</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    Es wird automatisiert ein neues Passwort für den User <strong><?php echo $_SESSION['username']; ?></strong> generiert und per Email verschickt.
                </div>
                <div class="mt-3">
                    <form method="post" action="index.php?site=instanz" name="form_newpassword" id="form_newpassword">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="newpassword-email" placeholder="name@example.com" name="newpassword-email">
                            <label for="newpassword-email">Email</label>
                        </div>
                        <input type="submit" class="btn btn-danger" value="Neues Passwort generieren" name="button_newpassword">
                    </form>
                </div>
            </div>
        </div>

        <!--<div class="row p-2 mt-2 border-bottom">
            <div class="col-4"><h5>Info</h5></div>
            <div class="col"><h5>Wert</h5></div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Instanz Uptime</div>
            <div class="col"><?php echo $tsAdmin->convertSecondsToStrTime($hostinfo['data']['instance_uptime']); ?></div>
        </div>
        <div class="row p-2">
            <div class="col-4">Timestamp</div>
            <div class="col"><?php echo date("d.m.Y - H:i",$hostinfo['data']['host_timestamp_utc']); ?></div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Server</div>
            <div class="col"><?php echo $hostinfo['data']['virtualservers_running_total']; ?></div>
        </div>
        <div class="row p-2">
            <div class="col-4">Slots (Summe)</div>
            <div class="col"><?php echo $hostinfo['data']['virtualservers_total_clients_online']; ?> / <?php echo $hostinfo['data']['virtualservers_total_maxclients']; ?></div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Channels (Summe)</div>
            <div class="col"><?php echo $hostinfo['data']['virtualservers_total_channels_online']; ?></div>
        </div>
        <div class="row p-2">
            <div class="col-4">Pakete gesendet</div>
            <div class="col"><?php echo number_format($hostinfo['data']['connection_packets_sent_total'],0,",","."); ?></div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Daten gesendet</div>
            <div class="col"><?php echo number_format(($hostinfo['data']['connection_bytes_sent_total']/pow(1024,3)),2,",","."); ?> Gbyte</div>
        </div>
        <div class="row p-2">
            <div class="col-4">Pakete empfangen</div>
            <div class="col"><?php echo number_format($hostinfo['data']['connection_packets_received_total'],0,",","."); ?></div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Daten empfangen</div>
            <div class="col"><?php echo number_format(($hostinfo['data']['connection_bytes_received_total']/pow(1024,3)),2,",","."); ?> Gbyte</div>
        </div>
        <div class="row p-2">
            <div class="col-4">Datenbank Version</div>
            <div class="col"><?php echo $instanceinfo['data']['serverinstance_database_version']; ?></div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Permissions Version</div>
            <div class="col"><?php echo $instanceinfo['data']['serverinstance_permissions_version']; ?></div>
        </div>
        <div class="row p-2">
            <div class="col-4">Filetransfer Port</div>
            <div class="col"><?php echo $instanceinfo['data']['serverinstance_filetransfer_port']; ?></div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Serverquery Flood Commands</div>
            <div class="col"><?php echo $instanceinfo['data']['serverinstance_serverquery_flood_commands']; ?></div>
        </div>
        <div class="row p-2">
            <div class="col-4">Serverquery Flood Time</div>
            <div class="col"><?php echo $instanceinfo['data']['serverinstance_serverquery_flood_time']; ?> Sekunden</div>
        </div>
        <div class="row p-2 bg-grey">
            <div class="col-4">Serverquery Flood Ban Time</div>
            <div class="col"><?php echo $instanceinfo['data']['serverinstance_serverquery_ban_time']; ?> Sekunden</div>
        </div>-->

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Info</th>
                        <th scope="col">Wert</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Instanz Uptime</td>
                        <td><?php echo $tsAdmin->convertSecondsToStrTime($hostinfo['data']['instance_uptime']); ?></td>
                    </tr>
                    <tr>
                        <td>Timestamp</td>
                        <td><?php echo date("d.m.Y - H:i",$hostinfo['data']['host_timestamp_utc']); ?></td>
                    </tr>
                    <tr>
                        <td>vServer</td>
                        <td><?php echo $hostinfo['data']['virtualservers_running_total']; ?></td>
                    </tr>
                    <tr>
                        <td>Slots (Summe)</td>
                        <td><?php echo $hostinfo['data']['virtualservers_total_clients_online']; ?> / <?php echo $hostinfo['data']['virtualservers_total_maxclients']; ?></td>
                    </tr>
                    <tr>
                        <td>Channels (Summe)</td>
                        <td><?php echo $hostinfo['data']['virtualservers_total_channels_online']; ?></td>
                    </tr>
                    <tr>
                        <td>Pakete gesendet</td>
                        <td><?php echo number_format($hostinfo['data']['connection_packets_sent_total'],0,",","."); ?></td>
                    </tr>
                    <tr>
                        <td>Daten gesendet</td>
                        <td><?php echo number_format(($hostinfo['data']['connection_bytes_sent_total']/pow(1024,3)),2,",","."); ?> Gbyte</td>
                    </tr>
                    <tr>
                        <td>Pakete empfangen</td>
                        <td><?php echo number_format($hostinfo['data']['connection_packets_received_total'],0,",","."); ?></td>
                    </tr>
                    <tr>
                        <td>Daten empfangen</td>
                        <td><?php echo number_format(($hostinfo['data']['connection_bytes_received_total']/pow(1024,3)),2,",","."); ?> Gbyte</td>
                    </tr>
                    <tr>
                        <td>Datenbank Version</td>
                        <td><?php echo $instanceinfo['data']['serverinstance_database_version']; ?></td>
                    </tr>
                    <tr>
                        <td>Permissions Version</td>
                        <td><?php echo $instanceinfo['data']['serverinstance_permissions_version']; ?></td>
                    </tr>
                    <tr>
                        <td>Filetransfer Port</td>
                        <td><?php echo $instanceinfo['data']['serverinstance_filetransfer_port']; ?></td>
                    </tr>
                    <tr>
                        <td>Serverquery Flood Commands</td>
                        <td><?php echo $instanceinfo['data']['serverinstance_serverquery_flood_commands']; ?></td>
                    </tr>
                    <tr>
                        <td>Serverquery Flood Time</td>
                        <td><?php echo $instanceinfo['data']['serverinstance_serverquery_flood_time']; ?> Sekunden</td>
                    </tr>
                    <tr>
                        <td>Serverquery Flood Ban Time</td>
                        <td><?php echo $instanceinfo['data']['serverinstance_serverquery_ban_time']; ?> Sekunden</td>
                    </tr>
                </tbody>
            </table>
        </div>

<?php
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