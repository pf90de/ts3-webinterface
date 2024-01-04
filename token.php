<?php
if(isset($_SESSION['loggedin'])) {
	if(!isset($_SESSION['vserver_port'])) {
        echo "<div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">";
        echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
        echo "<div>Es wurde kein vServer aus der <a href=\"index.php?site=server\" class=\"alert-link\">Serverliste</a> ausgewählt!</div>";
        echo "</div>";
	} else {
        if($tsAdmin->getElement('success', $tsAdmin->selectServer($_SESSION['vserver_port']))) {

			if($_POST['button_token_delete']) {
				if($tsAdmin->getElement('success', $tsAdmin->tokenDelete($_POST['hidden_token']))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Token erfolgreich gelöscht!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Token konnte nicht gelöscht werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			if($_POST['button_servertoken_add']) {
				if($tsAdmin->getElement('success', $output = $tsAdmin->tokenAdd(0,$_POST['servergroup_dropdown'],'',$_POST['token_description']))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Token erfolgreich erstellt.<br>Token: ".$output['data']['token']."";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Token konnte nicht erstellt werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			if($_POST['button_channeltoken_add']) {
				if($tsAdmin->getElement('success', $output = $tsAdmin->tokenAdd(1,$_POST['channelgroup_dropdown'],$_POST['channel_dropdown'],$_POST['token_description']))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Token erfolgreich erstellt.<br>Token: ".$output['data']['token']."";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Token konnte nicht erstellt werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

            $tsAdmin->selectServer($_SESSION['vserver_port']);

			$tsAdmin->selectServer($_SESSION['vserver_port']);
			$tokens = $tsAdmin->privilegekeyList();
			$servergroups = $tsAdmin->serverGroupList();
			$channelgroups = $tsAdmin->channelGroupList();
			$channels = $tsAdmin->channelList();

            ?>

            <div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasServerTokenAdd" aria-controls="offcanvasServerTokenAdd">Servertoken erstellen</button></div>
            <div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasChannelTokenAdd" aria-controls="offcanvasChannelTokenAdd">Channeltoken erstellen</button></div>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasServerTokenAdd" aria-labelledby="offcanvasServerTokenAddLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasServerTokenAddLabel"><i class="bi bi-plus-circle-fill"></i> Servertoken erstellen</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                        Es wird ein neuer Servertoken erstellt.
                    </div>
                    <div class="mt-3">
                        <form method="post" action="index.php?site=token" name="servertoken_add" id="servertoken_add">
                            <div class="form-floating mb-3">
								<select class="form-select" id="servergroup_dropdown" name="servergroup_dropdown" aria-label="Floating label select example">
								<?php
                                    foreach($servergroups['data'] as $servergroup) {
                                        if($servergroup['sgid'] > 5) {
                                            echo "<option value=\"".$servergroup['sgid']."\">[".$servergroup['sgid']."] ".$servergroup['name']."</option>";
                                        }
                                    }
								?>
								</select>
								<label for="servergroup_dropdown">Servergruppe</label>
							</div>
                            <div class="form-floating mb-3">
								<input type="text" class="form-control" id="token_description" name="token_description" placeholder="Beschreibung">
								<label for="token_description">Beschreibung</label>
							</div>
                            <input type="submit" class="btn btn-success" value="Erstellen" name="button_servertoken_add">
                        </form>
                    </div>
                </div>
            </div>

            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasChannelTokenAdd" aria-labelledby="offcanvasChannelTokenAddLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasChannelTokenAddLabel"><i class="bi bi-plus-circle-fill"></i> Channeltoken erstellen</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div>
                        Es wird ein neuer Channeltoken erstellt.
                    </div>
                    <div class="mt-3">
                        <form method="post" action="index.php?site=token" name="channeltoken_add" id="channeltoken_add">
                            <div class="form-floating mb-3">
								<select class="form-select" id="channelgroup_dropdown" name="channelgroup_dropdown" aria-label="Floating label select example">
								<?php
                                    foreach($channelgroups['data'] as $channelgroup) {
                                        if($channelgroup['cgid'] > 4) {
                                            echo "<option value=\"".$channelgroup['cgid']."\">[".$channelgroup['cgid']."] ".$channelgroup['name']."</option>";
                                        }
                                    }
								?>
								</select>
								<label for="channelgroup_dropdown">Channelgruppe</label>
							</div>
                            <div class="form-floating mb-3">
								<select class="form-select" id="channel_dropdown" name="channel_dropdown" aria-label="Floating label select example">
								<?php
                                    foreach($channels['data'] as $channel) {
                                        echo "<option value=\"".$channel['cid']."\">[".$channel['cid']."] ".$channel['channel_name']."</option>";
                                    }
								?>
								</select>
								<label for="channel_dropdown">Channel</label>
							</div>
                            <div class="form-floating mb-3">
								<input type="text" class="form-control" id="token_description" name="token_description" placeholder="Beschreibung">
								<label for="token_description">Beschreibung</label>
							</div>
                            <input type="submit" class="btn btn-success" value="Erstellen" name="button_channeltoken_add">
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Token</th>
                            <th scope="col">Typ</th>
                            <th scope="col">Gruppe</th>
                            <th scope="col">Channel</th>
                            <th scope="col">erstellt</th>
                            <th scope="col">Beschreibung</th>
                            <th scope="col" class="text-end">Aktion</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if(empty($tokens['data'])) {
                            echo "<tr>";
                            echo "<td colspan=\"7\">Keine Token verf&uuml;gbar.</td>";
                            echo "</tr>";
                        } else {
                            foreach($tokens['data'] as $token) {
                                echo "<tr>";
                                    echo "<td>".$token['token']."</td>";
                                    if($token['token_type'] == 0) {
                                        echo "<td>Server</td>";
                                        foreach($servergroups['data'] as $servergroup) {
                                            if($servergroup['sgid'] == $token['token_id1']) {
                                                echo "<td>".$servergroup['name']."</td>";
                                            }
                                        }
                                    } else {
                                        echo "<td>Channel</td>";
                                        foreach($channelgroups['data'] as $channelgroup) {
                                            if($channelgroup['cgid'] == $token['token_id1']) {
                                                echo "<td>".$channelgroup['name']."</td>";
                                            }
                                        }
                                    }
                                    if($token['token_id2'] == 0) {
                                        echo "<td>&nbsp;</td>";
                                    } else {
                                        foreach($channels['data'] as $channel) {
                                            if($channel['cid'] == $token['token_id2']) {
                                                echo "<td>".$channel['channel_name']."</td>";
                                            }
                                        }
                                    }
                                    echo "<td>".date("d.m.Y - H:i",$token['token_created'])."</td>";
                                    echo "<td>".$token['token_description']."</td>";
                                    echo "<td class=\"text-end\"><form method=\"post\" action=\"index.php?site=token\" name=\"token_delete\">
                                    <input type=\"hidden\" name=\"hidden_token\" value=".$token['token'].">
                                    <input type=\"submit\" class=\"btn btn-sm btn-danger\" name=\"button_token_delete\" value=\"Löschen\">
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