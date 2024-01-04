<?php
if(isset($_SESSION['loggedin'])) {
	if(!isset($_SESSION['vserver_port'])) {
        echo "<div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">";
        echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
        echo "<div>Es wurde kein vServer aus der <a href=\"index.php?site=server\" class=\"alert-link\">Serverliste</a> ausgewählt!</div>";
        echo "</div>";
	} else {
        if($tsAdmin->getElement('success', $tsAdmin->selectServer($_SESSION['vserver_port']))) {
            $tsAdmin->selectServer($_SESSION['vserver_port']);

			if($_POST['button_vserver_pw_edit']) {
				$data = array();
				$data['virtualserver_password'] = $_POST['edit_password'];
				if($tsAdmin->getElement('success', $tsAdmin->serverEdit($data))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Passwort erfolgreich geändert!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Passwort konnte nicht geändert werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}
			
			if($_POST['vserver_pw_delete']) {
				$data = array();
				$data['virtualserver_password'] = "";
				if($tsAdmin->getElement('success', $tsAdmin->serverEdit($data))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Passwort erfolgreich gelöscht!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Passwort konnte nicht gelöscht werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			if($_POST['button_send_gm']) {
				if($tsAdmin->getElement('success', $tsAdmin->gm($_POST['gm']))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Nachricht erfolgreich gesendet.";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Nachricht konnte nicht gesendet werden.";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			if($_POST['button_vserver_edit']) {
				$data = array();
				$data['virtualserver_name'] = $_POST['edit_servername'];
				$data['virtualserver_welcomemessage'] = $_POST['edit_welcomemessage'];
				if($_POST['edit_codec_encryption_mode'] == "Global aus") {
					$data['virtualserver_codec_encryption_mode'] = 1;
				} elseif($_POST['edit_codec_encryption_mode'] == "Global an") {
					$data['virtualserver_codec_encryption_mode'] = 2;
				} else {
					$data['virtualserver_codec_encryption_mode'] = 0;
				}
				if($_POST['edit_autostart'] == "Ja") {
					$data['virtualserver_autostart'] = 1;
				} else {
					$data['virtualserver_autostart'] = 0;
				}
				if($_POST['edit_weblist'] == "Ja") {
					$data['virtualserver_weblist_enabled'] = 1;
				} else {
					$data['virtualserver_weblist_enabled'] = 0;
				}
				$data['virtualserver_default_server_group'] = $_POST['edit_default_server_group'];
				$data['virtualserver_default_channel_group'] = $_POST['edit_default_channel_group'];
				$data['virtualserver_default_channel_admin_group'] = $_POST['edit_default_channel_admin_group'];
				if($_POST['edit_hostmessage_mode'] == "Keine Nachricht") {
					$data['virtualserver_hostmessage_mode'] = 0;
				} elseif($_POST['edit_hostmessage_mode'] == "Nachricht im Log anzeigen") {
					$data['virtualserver_hostmessage_mode'] = 1;
				} elseif($_POST['edit_hostmessage_mode'] == "Nachricht als Fenster anzeigen") {
					$data['virtualserver_hostmessage_mode'] = 2;
				} else {
					$data['virtualserver_hostmessage_mode'] = 3;
				}
				$data['virtualserver_hostmessage'] = $_POST['edit_hostmessage'];
				$data['virtualserver_hostbanner_url'] = $_POST['edit_hostbanner_url'];
				$data['virtualserver_hostbanner_gfx_url'] = $_POST['edit_hostbanner_gfx_url'];
				$data['virtualserver_hostbanner_gfx_interval'] = $_POST['edit_hostbanner_gfx_interval'];
				if($_POST['edit_hostbanner_mode'] == "Anpassen, Seitenverhältnis ignorieren") {
					$data['virtualserver_hostbanner_mode'] = 1;
				} elseif($_POST['edit_hostbanner_mode'] == "Anpassen, Seitenverhältnis beachten") {
					$data['virtualserver_hostbanner_mode'] = 2;
				} else {
					$data['virtualserver_hostbanner_mode'] = 0;
				}
				$data['virtualserver_hostbutton_tooltip'] = $_POST['edit_hostbutton_tooltip'];
				$data['virtualserver_hostbutton_url'] = $_POST['edit_hostbutton_url'];
				$data['virtualserver_hostbutton_gfx_url'] = $_POST['edit_hostbutton_gfx_url'];
				if($tsAdmin->getElement('success', $tsAdmin->serverEdit($data))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "vServer erfolgreich editiert!";
					echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "vServer konnte nicht editiert werden!";
					echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			$info = $tsAdmin->serverInfo();
			$servergroups = $tsAdmin->serverGroupList();
			$channelgroups = $tsAdmin->channelGroupList();
            ?>

			<div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasVserverEdit" aria-controls="offcanvasVserverEdit">Bearbeiten</button></div>

			<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasVserverEdit" aria-labelledby="offcanvasVserverEditLabel">
				<div class="offcanvas-header">
					<h5 class="offcanvas-title" id="offcanvasVserverEditLabel"><i class="bi bi-exclamation-triangle-fill"></i> vServer bearbeiten</h5>
					<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<div>
						Zur Anpassung von Einstellungen die entsprechenden Felder bearbeiten und speichern.
					</div>
					<div class="mt-3">
						<form method="post" action="index.php?site=vserver" name="form_shutdown" id="form_vserver_edit">
							<h5>Allgemein</h5>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_servername" name="edit_servername" placeholder="<?php echo $info['data']['virtualserver_name']; ?>" value="<?php echo $info['data']['virtualserver_name']; ?>">
								<label for="edit_servername">Servername</label>
							</div>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_welcomemessage" name="edit_welcomemessage" placeholder="<?php echo $info['data']['virtualserver_welcomemessage']; ?>" value="<?php echo $info['data']['virtualserver_welcomemessage']; ?>">
								<label for="edit_welcomemessage">Willkommensnachricht</label>
							</div>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_codec_encryption_mode" name="edit_codec_encryption_mode" aria-label="Floating label select example">
								<?php
									if($info['data']['virtualserver_codec_encryption_mode'] == 1) {
										echo "<option selected>Global aus</option>
											<option>Global an</option>
											<option>Channel individuell einstellen</option>";
									} elseif($info['data']['virtualserver_codec_encryption_mode'] == 2) {
										echo "<option selected>Global an</option>
											<option>Global aus</option>
											<option>Channel individuell einstellen</option>";
									} else {
										echo "<option selected>Channel individuell einstellen</option>
											<option>Global aus</option>
											<option>Global an</option>";
									}
								?>
								</select>
								<label for="edit_codec_encryption_mode">Codec Encryption Mode</label>
							</div>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_autostart" name="edit_autostart" aria-label="Floating label select example">
								<?php
									if($info['data']['virtualserver_autostart'] == 1) {
										echo "<option selected>Ja</option>
											<option>Nein</option>";
									} else {
										echo "<option selected>Nein</option>
											<option>Ja</option>";
									}
								?>
								</select>
								<label for="edit_autostart">Autostart</label>
							</div>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_weblist" name="edit_weblist" aria-label="Floating label select example">
								<?php
									if($info['data']['virtualserver_weblist_enabled'] == 1) {
										echo "<option selected>Ja</option>
											<option>Nein</option>";
									} else {
										echo "<option selected>Nein</option>
											<option>Ja</option>";
									}
								?>
								</select>
								<label for="edit_weblist">Server in Webliste</label>
							</div>
							<h5>Default Groups</h5>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_default_server_group" name="edit_default_server_group" aria-label="Floating label select example">
								<?php
									foreach($servergroups['data'] as $servergroup) {
										if($servergroup['sgid'] > 5) {
											if ($servergroup['sgid'] == $info['data']['virtualserver_default_server_group']) {
												echo "<option value=\"".$servergroup['sgid']."\" selected>[".$servergroup['sgid']."] ".$servergroup['name']."</option>";
											} else {
												echo "<option value=\"".$servergroup['sgid']."\">[".$servergroup['sgid']."] ".$servergroup['name']."</option>";
											}
										}
									}
								?>
								</select>
								<label for="edit_default_server_group">Default Server Group</label>
							</div>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_default_channel_group" name="edit_default_channel_group" aria-label="Floating label select example">
								<?php
									foreach($channelgroups['data'] as $channelgroup) {
										if($channelgroup['cgid'] > 4) {
											if ($channelgroup['cgid'] == $info['data']['virtualserver_default_channel_group']) {
												echo "<option value=\"".$channelgroup['cgid']."\" selected>[".$channelgroup['cgid']."] ".$channelgroup['name']."</option>";
											} else {
												echo "<option value=\"".$channelgroup['cgid']."\">[".$channelgroup['cgid']."] ".$channelgroup['name']."</option>";
											}
										}
									}
								?>
								</select>
								<label for="edit_default_channel_group">Default Channel Group</label>
							</div>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_default_channel_admin_group" name="edit_default_channel_admin_group" aria-label="Floating label select example">
								<?php
									foreach($channelgroups['data'] as $channelgroup) {
										if($channelgroup['cgid'] > 4) {
											if ($channelgroup['cgid'] == $info['data']['virtualserver_default_channel_admin_group']) {
												echo "<option value=\"".$channelgroup['cgid']."\" selected>[".$channelgroup['cgid']."] ".$channelgroup['name']."</option>";
											} else {
												echo "<option value=\"".$channelgroup['cgid']."\">[".$channelgroup['cgid']."] ".$channelgroup['name']."</option>";
											}
										}
									}
								?>
								</select>
								<label for="edit_default_channel_admin_group">Default Channel Admin Group</label>
							</div>
							<h5>Hostmessage</h5>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_hostmessage" name="edit_hostmessage" placeholder="<?php echo $info['data']['virtualserver_hostmessage']; ?>" value="<?php echo $info['data']['virtualserver_hostmessage']; ?>">
								<label for="edit_hostmessage">Hostmessage</label>
							</div>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_hostmessage_mode" name="edit_hostmessage_mode" aria-label="Floating label select example">
								<?php
									if($info['data']['virtualserver_hostmessage_mode'] == 0) {
										echo "<option selected>Keine Nachricht</option>
											<option>Nachricht im Log anzeigen</option>
											<option>Nachricht als Fenster anzeigen</option>
											<option>Nachricht als Fenster anzeigen und Verbindung trennen</option>";
									} elseif($info['data']['virtualserver_hostmessage_mode'] == 1) {
										echo "<option selected>Nachricht im Log anzeigen</option>
											<option>Keine Nachricht</option>
											<option>Nachricht als Fenster anzeigen</option>
											<option>Nachricht als Fenster anzeigen und Verbindung trennen</option>";
									} elseif($info['data']['virtualserver_hostmessage_mode'] == 2) {
										echo "<option selected>Nachricht als Fenster anzeigen</option>
											<option>Keine Nachricht</option>
											<option>Nachricht im Log anzeigen</option>
											<option>Nachricht als Fenster anzeigen und Verbindung trennen</option>";
									} else {
										echo "<option selected>Nachricht als Fenster anzeigen und Verbindung trennen</option>
											<option>Keine Nachricht</option>
											<option>Nachricht im Log anzeigen</option>
											<option>Nachricht als Fenster anzeigen</option>";
									}
								?>
								</select>
								<label for="edit_hostmessage_mode">Hostmessage Mode</label>
							</div>
							<h5>Hostbanner</h5>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_hostbanner_url" name="edit_hostbanner_url" placeholder="<?php echo $info['data']['virtualserver_hostbanner_url']; ?>" value="<?php echo $info['data']['virtualserver_hostbanner_url']; ?>">
								<label for="edit_hostbanner_url">Hostbanner URL</label>
							</div>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_hostbanner_gfx_url" name="edit_hostbanner_gfx_url" placeholder="<?php echo $info['data']['virtualserver_hostbanner_gfx_url']; ?>" value="<?php echo $info['data']['virtualserver_hostbanner_gfx_url']; ?>">
								<label for="edit_hostbanner_gfx_url">Hostbanner Gfx URL</label>
							</div>
							<div class="form-floating mb-3">
								<input type="number" class="form-control" id="edit_hostbanner_gfx_interval" name="edit_hostbanner_gfx_interval" placeholder="<?php echo $info['data']['virtualserver_hostbanner_gfx_interval']; ?>" value="<?php echo $info['data']['virtualserver_hostbanner_gfx_interval']; ?>">
								<label for="edit_hostbanner_gfx_interval">Hostbanner Gfx Intervall</label>
							</div>
							<div class="form-floating mb-3">
								<select class="form-select" id="edit_hostbanner_mode" name="edit_hostbanner_mode" aria-label="Floating label select example">
								<?php
									if($info['data']['virtualserver_hostbanner_mode'] == 1) {
										echo "<option selected>Anpassen, Seitenverhältnis ignorieren</option>
											<option>Anpassen, Seitenverhältnis beachten</option>
											<option>Nicht anpassen</option>";
									} elseif($info['data']['virtualserver_hostbanner_mode'] == 2) {
										echo "<option selected>Anpassen, Seitenverhältnis beachten</option>
											<option>Anpassen, Seitenverhältnis ignorieren</option>
											<option>Nicht anpassen</option>";
									} else {
										echo "<option selected>Nicht anpassen</option>
											<option>Anpassen, Seitenverhältnis ignorieren</option>
											<option>Anpassen, Seitenverhältnis beachten</option>";
									}
								?>
								</select>
								<label for="edit_hostbanner_mode">Hostbanner Mode</label>
							</div>
							<h5>Hostbutton</h5>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_hostbutton_tooltip" name="edit_hostbutton_tooltip" placeholder="<?php echo $info['data']['virtualserver_hostbutton_tooltip']; ?>" value="<?php echo $info['data']['virtualserver_hostbutton_tooltip']; ?>">
								<label for="edit_hostbutton_tooltip">Hostbutton Tooltip</label>
							</div>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_hostbutton_url" name="edit_hostbutton_url" placeholder="<?php echo $info['data']['virtualserver_hostbutton_url']; ?>" value="<?php echo $info['data']['virtualserver_hostbutton_url']; ?>">
								<label for="edit_hostbutton_url">Hostbutton URL</label>
							</div>
							<div class="form-floating mb-3">
								<input type="text" class="form-control" id="edit_hostbutton_gfx_url" name="edit_hostbutton_gfx_url" placeholder="<?php echo $info['data']['virtualserver_hostbutton_gfx_url']; ?>" value="<?php echo $info['data']['virtualserver_hostbutton_gfx_url']; ?>">
								<label for="edit_hostbutton_gfx_url">Hostbutton Gfx URL</label>
							</div>
							<input type="submit" class="btn btn-success" value="Speichern" name="button_vserver_edit">
						</form>
					</div>
				</div>
			</div>

            <h3>Globale Nachricht</h3>
            <form method="post" action="index.php?site=vserver" name="form_gm">
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Globale Nachricht" id="gm" style="height: 100px" name="gm"></textarea>
                    <label for="gm">Globale Nachricht</label>
                </div>
                <input type="submit" class="btn btn-success mb-3" value="Senden" name="button_send_gm">
            </form>

			<h3>Passwort</h3>
			<form method="post" action="index.php?site=vserver" name="form_password">
                <div class="form-floating mb-3">
                    <?php
                        if($info['data']['virtualserver_password'] == "") {
                            echo "<input type=\"password\" class=\"form-control\" id=\"edit_password\" placeholder=\"Passwort\" name=\"edit_password\">";
                            echo "<label for=\"edit_password\">Passwort</label>";
                        } else {
                            echo "<input type=\"password\" class=\"form-control\" id=\"edit_password\" placeholder=\"Passwort\" value=\"".$info['data']['virtualserver_password']." (verschl&uuml;sselt)\" name=\"edit_password\">";
                            echo "<label for=\"edit_password\">Passwort</label>";
                        }
                    ?>
                </div>
                <button type="button" class="btn btn-dark mb-3" onclick="myFunction()">Passwort anzeigen</button>
                <input type="submit" class="btn btn-success mb-3" value="Ändern" name="button_vserver_pw_edit">
                <?php
                    if($info['data']['virtualserver_password'] != "") {
                    ?>
                        <input type="submit" class="btn btn-danger mb-3" name="vserver_pw_delete" value="Passwort löschen">
                    <?php
                    }
                ?>
            </form>

            <h3>Allgemein</h3>
            <div class="table-responsive mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Info</th>
                            <th scope="col">Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
							<td>Name</td>
							<td><strong><?php echo $info['data']['virtualserver_name']; ?></strong></td>
						</tr>
						<tr>
							<td>UID</td>
							<td><?php echo $info['data']['virtualserver_unique_identifier']; ?></td>
						</tr>
						<tr>
							<td>ID</td>
							<td><?php echo $info['data']['virtualserver_id']; ?></td>
						</tr>
						<tr>
							<td>Port</td>
							<td><?php echo $info['data']['virtualserver_port']; ?></td>
						</tr>
						<tr>
							<td>Version</td>
							<td><?php echo $info['data']['virtualserver_version']; ?></td>
						</tr>
						<tr>
							<td>Plattform</td>
							<td><?php echo $info['data']['virtualserver_platform']; ?></td>
						</tr>
						<tr>
							<td>Erstellungsdatum</td>
							<td><?php echo date("d.m.Y - H:i",$info['data']['virtualserver_created']); ?></td>
						</tr>
						<tr>
							<td>Uptime</td>
							<td><?php echo $tsAdmin->convertSecondsToStrTime($info['data']['virtualserver_uptime']); ?></td>
						</tr>
						<tr>
							<td>Slots</td>
							<td><?php echo $info['data']['virtualserver_clientsonline']; ?> / <?php echo $info['data']['virtualserver_maxclients']; ?></td>
						</tr>
						<tr>
							<td>Channels</td>
							<td><?php echo $info['data']['virtualserver_channelsonline']; ?></td>
						</tr>
                        <tr>
							<td>Autostart</td>
							<td><?php 
									if($info['data']['virtualserver_autostart'] == 1) {
										echo "Ja";
									} else {
										echo "Nein";
									}
								?>
							</td>
						</tr>
						<tr>
							<td>Passwort</td>
							<td><?php 
									if($info['data']['virtualserver_password'] == "") {
										echo "<em>Keine Passwort gesetzt</em>";
									} else {
										echo $info['data']['virtualserver_password']." <em>(verschlüsselt)</em> <i class=\"bi bi-lock-fill\">";
									}
								?>
							</td>
						</tr>
						<tr>
							<td>Codec Encryption Mode</td>
							<td><?php
									if($info['data']['virtualserver_codec_encryption_mode'] == 1) {
										echo "Global aus";
									} elseif($info['data']['virtualserver_codec_encryption_mode'] == 2) {
										echo "Global an";
									} else {
										echo "Channel individuell einstellen";
									}
								?></td>
						</tr>
						<tr>
							<td>Server in Webliste</td>
							<td><?php 
									if($info['data']['virtualserver_weblist_enabled'] == 1) {
										echo "Ja";
									} else {
										echo "Nein";
									}
								?></td>
						</tr>
						<tr>
							<td>Willkommensnachricht</td>
							<td><?php 
									if($info['data']['virtualserver_welcomemessage'] == "") {
										echo "<em>Keine Willkommensnachricht gesetzt</em>";
									} else {
										echo $info['data']['virtualserver_welcomemessage'];
									}
								?>
							</td>
						</tr>
                    </tbody>
                </table>
            </div>

            <h3>Default Groups</h3>
            <div class="table-responsive mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Info</th>
                            <th scope="col">Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
							<td>Server Group</td>
							<td>
								<?php
								foreach($servergroups['data'] as $servergroup) {
									if($servergroup['sgid'] == $info['data']['virtualserver_default_server_group']) {
										echo "[".$servergroup['sgid']."] ".$servergroup['name'];
									}
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Channel Group</td>
							<td>
								<?php
								foreach($channelgroups['data'] as $channelgroup) {
									if($channelgroup['cgid'] == $info['data']['virtualserver_default_channel_group']) {
										echo "[".$channelgroup['cgid']."] ".$channelgroup['name'];
									}
								}
								?>
							</td>
						</tr>
						<tr>
							<td>Channel Admin Group</td>
							<td>
								<?php
								foreach($channelgroups['data'] as $channelgroup) {
									if($channelgroup['cgid'] == $info['data']['virtualserver_default_channel_admin_group']) {
										echo "[".$channelgroup['cgid']."] ".$channelgroup['name'];
									}
								}
								?>
							</td>
						</tr>
                    </tbody>
                </table>
            </div>

            <h3>Hostmessage</h3>
            <div class="table-responsive mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Info</th>
                            <th scope="col">Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
							<td>Hostmessage</td>
							<td><?php 
									if($info['data']['virtualserver_hostmessage'] == "") {
										echo "<em>Keine Hostmessage gesetzt</em>";
									} else {
										echo $info['data']['virtualserver_hostmessage'];
									}
								?>
							</td>
						</tr>
						<tr>
							<td>Hostmessage Mode</td>
							<td><?php if($info['data']['virtualserver_hostmessage_mode'] == 0) {
									echo "Keine Nachricht";
								} elseif($info['data']['virtualserver_hostmessage_mode'] == 1) {
									echo "Nachricht im Log anzeigen";
								} elseif($info['data']['virtualserver_hostmessage_mode'] == 2) {
									echo "Nachricht als Fenster anzeigen";
								} else {
									echo "Nachricht als Fenster anzeigen und Verbindung trennen";
								}
								?></td>
						</tr>
                    </tbody>
                </table>
            </div>

            <h3>Hostbanner</h3>
            <div class="table-responsive mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Info</th>
                            <th scope="col">Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
							<td>Hostbanner URL</td>
							<td><?php echo $info['data']['virtualserver_hostbanner_url']; ?></td>
						</tr>
						<tr>
							<td>Hostbanner Gfx URL</td>
							<td><?php echo $info['data']['virtualserver_hostbanner_gfx_url']; ?></td>
						</tr>
						<tr>
							<td>Hostbanner Gfx Intervall</td>
							<td><?php echo $info['data']['virtualserver_hostbanner_gfx_interval']; ?></td>
						</tr>
						<tr>
							<td>Hostbanner Mode</td>
							<td><?php if($info['data']['virtualserver_hostbanner_mode'] == 0) {
									echo "Nicht anpassen";
								} elseif($info['data']['virtualserver_hostbanner_mode'] == 1) {
									echo "Anpassen, Seitenverhältnis ignorieren";
								} elseif($info['data']['virtualserver_hostbanner_mode'] == 2) {
									echo "Anpassen, Seitenverhältnis beachten";
								}
								?></td>
						</tr>
                    </tbody>
                </table>
            </div>

            <h3>Hostbutton</h3>
            <div class="table-responsive mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Info</th>
                            <th scope="col">Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
							<td>Hostbutton Tooltip</td>
							<td><?php echo $info['data']['virtualserver_hostbutton_tooltip']; ?></td>
						</tr>
						<tr>
							<td>Hostbutton URL</td>
							<td><?php echo $info['data']['virtualserver_hostbutton_url']; ?></td>
						</tr>
						<tr>
							<td>Hostbutton Gfx URL</td>
							<td><?php echo $info['data']['virtualserver_hostbutton_gfx_url']; ?></td>
						</tr>
                    </tbody>
                </table>
            </div>

            <h3>Client Versionen</h3>
            <div class="table-responsive mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Info</th>
                            <th scope="col">Wert</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
							<td>Min. Client Version</td>
							<td><?php echo "Build: ".$info['data']['virtualserver_min_client_version']; ?></td>
						</tr>
						<tr>
							<td>Min. Android Client Version</td>
							<td><?php echo "Build: ".$info['data']['virtualserver_min_android_version']; ?></td>
						</tr>
						<tr>
							<td>Min. iOS Client Version</td>
							<td><?php echo "Build: ".$info['data']['virtualserver_min_ios_version']; ?></td>
						</tr>
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