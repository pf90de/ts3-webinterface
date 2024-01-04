<?php
if(isset($_SESSION['loggedin'])) {
	if($_POST['button_vserver_stop']) {
		if($tsAdmin->getElement('success', $tsAdmin->serverStop($_POST['hidden_vserver_id']))) {
			echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
			echo "Der vServer mit ID ".$_POST['hidden_vserver_id']." wurde erfolgreich gestoppt.";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		} else {
			echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
			echo "Der vServer mit ID ".$_POST['hidden_vserver_id']." konnte nicht gestoppt werden.";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		}
	}
	if($_POST['button_vserver_start']) {
		if($tsAdmin->getElement('success', $tsAdmin->serverStart($_POST['hidden_vserver_id']))) {
			echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
			echo "Der vServer mit ID ".$_POST['hidden_vserver_id']." wurde erfolgreich gestartet.";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		} else {
			echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
			echo "Der vServer mit ID ".$_POST['hidden_vserver_id']." konnte nicht gestartet werden.";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		}
	}
	if($_POST['button_vserver_delete']) {
		if($tsAdmin->getElement('success', $tsAdmin->serverDelete($_POST['hidden_vserver_id']))) {
			echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
			echo "Der vServer mit ID ".$_POST['hidden_vserver_id']." wurde erfolgreich gelöscht.";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		} else {
			echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
			echo "Der vServer mit ID ".$_POST['hidden_vserver_id']." konnte nicht gelöscht werden.";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		}
	}
	if($_POST['button_vserver_select']) {
		$_SESSION['vserver_port'] = $_POST['hidden_vserver_port'];
        $_SESSION['vserver_id'] = $_POST['hidden_vserver_id'];
		header("Location: index.php?site=vserver");
	}
    if($_POST['button_server_create']) {
		$data = array();
		$data['virtualserver_name'] = $_POST['servername'];
		$data['virtualserver_maxclients'] = $_POST['slots'];
		$data['virtualserver_password'] = $_POST['serverpw'];
		$data['virtualserver_port'] = $_POST['port'];
		if($tsAdmin->getElement('success', $output = $tsAdmin->serverCreate($data))) {
			echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
			echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
			echo "Der vServer (ID ".$output['data']['sid'].") mit Port ".$output['data']['virtualserver_port']." wurde erfolgreich erstellt. SA Token: ".$output['data']['token']."";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		} else {
			echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
            echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
			echo "vServer konnte nicht erstellt werden.";
            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
			echo "</div>";
		}
    }
    ?>

    <div class="d-inline-flex"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCreateVserver" aria-controls="offcanvasCreateVserver">vServer erstellen</button></div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasCreateVserver" aria-labelledby="offcanvasCreateVserverLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasCreateVserverLabel">vServer erstellen</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div>
                    Bitte notieren Sie sich zwingend den nach der Erstellung generierten <strong>SA Token</strong>, um die erforderliche Administrationsrechte im Teamspeak Client einzufordern.
                </div>
                <div class="mt-3">
                    <form method="post" action="index.php?site=server" name="form_vserver_create" id="form_vserver_create">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="servername" name="servername" placeholder="Servername">
                            <label for="servername">Servername</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="serverpw" name="serverpw" placeholder="Passwort">
                            <label for="serverpw">Passwort (optional)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="slots" name="slots" placeholder="32" min="10" max="50">
                            <label for="slots">Slots</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="port" name="port" min="9987" max="9999" placeholder="9987">
                            <label for="port">Port</label>
                        </div>
                        <input type="submit" class="btn btn-success" value="Erstellen" name="button_server_create">
                    </form>
                </div>
            </div>
        </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Port</th>
                    <th scope="col">Slots</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-end">Aktion</th>
                </tr>
            </thead>
            <tbody>
            <?php
				$servers = $tsAdmin->serverList();
				foreach($servers['data'] as $server) {
                    $tsAdmin->selectServer($server['virtualserver_port']);
                    $info = $tsAdmin->serverInfo();
					echo "<tr>";
						echo "<td>".$server['virtualserver_id']."</td>";
						if($info['data']['virtualserver_password'] == "" || !isset($info['data']['virtualserver_password'])) {
							echo "<td>".$server['virtualserver_name']."</td>";
						} else {
							echo "<td>".$server['virtualserver_name']." <i class=\"bi bi-lock-fill\"></td>";
						}
						echo "<td>".$server['virtualserver_port']."</td>";
						if($server['virtualserver_status'] == 'online') {
							echo "<td>".$server['virtualserver_clientsonline']." / ".$server['virtualserver_maxclients']."</td>";
							echo "<td><span class=\"badge bg-success\">online</span></td>";
							echo "<td class=\"text-end\"><form method=\"post\" action=\"index.php?site=server\" name=\"vserver_stop\">
                                    <input type=\"hidden\" name=\"hidden_vserver_port\" value=".$server['virtualserver_port'].">
                                    <input type=\"hidden\" name=\"hidden_vserver_id\" value=".$server['virtualserver_id'].">
                                    <input type=\"submit\" class=\"btn btn-danger btn-sm\" name=\"button_vserver_stop\" value=\"Stopp\">
                                    <input type=\"submit\" class=\"btn btn-info btn-sm\" name=\"button_vserver_select\" value=\"Auswählen\">
                                    <a href=\"ts3server://".$_SESSION['ts3ip']."/?port=".$server['virtualserver_port']."\" class=\"btn btn-sm btn-dark\" role=\"button\">Connect</a>
								</form></td>";
						} else {
							echo "<td>&nbsp;</td>";
							echo "<td><span class=\"badge bg-danger\">offline</span></td>";
							echo "<td class=\"text-end\"><form method=\"post\" action=\"index.php?site=server\" name=\"vserver_start\">
                                    <input type=\"hidden\" name=\"hidden_vserver_port\" value=".$server['virtualserver_port'].">
                                    <input type=\"hidden\" name=\"hidden_vserver_id\" value=".$server['virtualserver_id'].">
                                    <input type=\"submit\" class=\"btn btn-success btn-sm\" name=\"button_vserver_start\" value=\"Start\">
                                    <input type=\"submit\" class=\"btn btn-danger btn-sm\" name=\"button_vserver_delete\" value=\"Löschen\">
								</form></td>";
						}
					echo "</tr>";
				}
				?>
            </tbody>
        </table>
    </div>
    <?php
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