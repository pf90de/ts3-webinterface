<?php
if(isset($_SESSION['loggedin'])) {
	if(!isset($_SESSION['vserver_port'])) {
        echo "<div class=\"alert alert-danger d-flex align-items-center\" role=\"alert\">";
        echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
        echo "<div>Es wurde kein vServer aus der <a href=\"index.php?site=server\" class=\"alert-link\">Serverliste</a> ausgewählt!</div>";
        echo "</div>";
	} else {
        if($tsAdmin->getElement('success', $tsAdmin->selectServer($_SESSION['vserver_port']))) {

			//CHANNEL LÖSCHEN
			if($_POST['button_channel_delete']) {
				if($tsAdmin->getElement('success', $tsAdmin->channelDelete($_POST['hidden_cid']))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Der Channel ".$_POST['hidden_channel_name']." wurde erfolgreich gelöscht!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Channel ".$_POST['hidden_channel_name']." konnte nicht gelöscht werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			//CHANNEL HINZUFÜGEN
			if($_POST['button_channel_add']) {
				$permissions = array();
				$data = array();
				$data['channel_name'] = $_POST['channelname'];
				$data['channel_description'] = $_POST['description'];
				if($_POST['channelpassword'] != "") {
					$data['channel_password'] = $_POST['channelpassword'];
				}
				if($_POST['permanent'] == "Ja") {
					$data['channel_flag_permanent'] = 1;
				} else {
					$data['channel_flag_semi_permanent'] = 1;
				}
				if($_POST['codec'] == "Speex Schmalband") {
					$data['channel_codec'] = 0;
				} elseif($_POST['codec'] == "Speex Breitband") {
					$data['channel_codec'] = 1;
				} elseif($_POST['codec'] == "Speex Ultra-Breitband") {
					$data['channel_codec'] = 2;
				} elseif($_POST['codec'] == "CELT Mono") {
					$data['channel_codec'] = 3;
				} elseif($_POST['codec'] == "Opus Voice") {
					$data['channel_codec'] = 4;
				} else {
					$data['channel_codec'] = 5;
				}
				if($_POST['codec_quality'] == "2.73 KiB/s") {
					$data['channel_codec_quality'] = 0;
				} elseif($_POST['codec_quality'] == "3.22 KiB/s") {
					$data['channel_codec_quality'] = 1;
				} elseif($_POST['codec_quality'] == "3.71 KiB/s") {
					$data['channel_codec_quality'] = 2;
				} elseif($_POST['codec_quality'] == "4.20 KiB/s") {
					$data['channel_codec_quality'] = 3;
				} elseif($_POST['codec_quality'] == "4.74 KiB/s") {
					$data['channel_codec_quality'] = 4;
				} elseif($_POST['codec_quality'] == "5.22 KiB/s") {
					$data['channel_codec_quality'] = 5;
				} elseif($_POST['codec_quality'] == "5.71 KiB/s") {
					$data['channel_codec_quality'] = 6;
				} elseif($_POST['codec_quality'] == "6.20 KiB/s") {
					$data['channel_codec_quality'] = 7;
				} elseif($_POST['codec_quality'] == "6.74 KiB/s") {
					$data['channel_codec_quality'] = 8;
				} elseif($_POST['codec_quality'] == "7.23 KiB/s") {
					$data['channel_codec_quality'] = 9;
				} else {
					$data['channel_codec_quality'] = 10;
				}
				if($_POST['parentchannel'] != "Kein übergeordneter Channel") {
					$data['cpid'] = $_POST['parentchannel'];
				}
				if($_POST['talk_power'] == "") {
					$data['channel_needed_talk_power'] = 0;
				} else {
					$data['channel_needed_talk_power'] = $_POST['talk_power'];
				}
				$permissions['i_channel_needed_permission_modify_power'] = 75;
				$permissions['i_channel_needed_modify_power'] = $_POST['modify_power'];
				$permissions['i_channel_needed_delete_power'] = $_POST['delete_power'];
				if($tsAdmin->getElement('success', $output = $tsAdmin->channelCreate($data))) {
					if($tsAdmin->getElement('success', $tsAdmin->channelAddPerm($output['data']['cid'],$permissions))) {
                        echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                        echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
                        echo "Der Channel ".$data['channel_name']." wurde erfolgreich erstellt!";
                        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                        echo "</div>";
					}
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Der Channel ".$data['channel_name']." konnte nicht erstellt werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			//CHANNEL PW ÄNDERN
			if($_POST['button_channel_pw_edit']) {
				$data = array();
				$data['channel_password'] = $_POST['edit_password'];
				if($tsAdmin->getElement('success', $tsAdmin->channelEdit($_POST['pw_edit_hidden_cid'],$data))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Das Passwort wurde erfolgreich geändert!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Das Passwort konnte nicht geändert werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			//CHANNEL PW LÖSCHEN
			if($_POST['button_channel_pw_delete']) {
				$data = array();
				$data['channel_password'] = "";
				if($tsAdmin->getElement('success', $tsAdmin->channelEdit($_POST['pw_edit_hidden_cid'],$data))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Das Passwort wurde erfolgreich gelöscht!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Das Passwort konnte nicht gelöscht werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			//CHANNEL ÄNDERN
			if($_POST['button_channel_edit']) {
				$data = array();
				if($_POST['channel_edit_hidden_channel_name'] != $_POST['edit_channelname']) {
					$data['channel_name'] = $_POST['edit_channelname'];
				}
				$data['channel_description'] = $_POST['edit_channel_description'];
				if($_POST['edit_codec'] == "Speex Schmalband") {
					$data['channel_codec'] = 0;
				} elseif($_POST['edit_codec'] == "Speex Breitband") {
					$data['channel_codec'] = 1;
				} elseif($_POST['edit_codec'] == "Speex Ultra-Breitband") {
					$data['channel_codec'] = 2;
				} elseif($_POST['edit_codec'] == "CELT Mono") {
					$data['channel_codec'] = 3;
				} elseif($_POST['edit_codec'] == "Opus Voice") {
					$data['channel_codec'] = 4;
				} else {
					$data['channel_codec'] = 5;
				}
				if($_POST['edit_codec_quality'] == "2.73 KiB/s") {
					$data['channel_codec_quality'] = 0;
				} elseif($_POST['edit_codec_quality'] == "3.22 KiB/s") {
					$data['channel_codec_quality'] = 1;
				} elseif($_POST['edit_codec_quality'] == "3.71 KiB/s") {
					$data['channel_codec_quality'] = 2;
				} elseif($_POST['edit_codec_quality'] == "4.20 KiB/s") {
					$data['channel_codec_quality'] = 3;
				} elseif($_POST['edit_codec_quality'] == "4.74 KiB/s") {
					$data['channel_codec_quality'] = 4;
				} elseif($_POST['edit_codec_quality'] == "5.22 KiB/s") {
					$data['channel_codec_quality'] = 5;
				} elseif($_POST['edit_codec_quality'] == "5.71 KiB/s") {
					$data['channel_codec_quality'] = 6;
				} elseif($_POST['edit_codec_quality'] == "6.20 KiB/s") {
					$data['channel_codec_quality'] = 7;
				} elseif($_POST['edit_codec_quality'] == "6.74 KiB/s") {
					$data['channel_codec_quality'] = 8;
				} elseif($_POST['edit_codec_quality'] == "7.23 KiB/s") {
					$data['channel_codec_quality'] = 9;
				} else {
					$data['channel_codec_quality'] = 10;
				}
				if($_POST['edit_channel_needed_talk_power'] == "") {
					$data['channel_needed_talk_power'] = 0;
				} else {
					$data['channel_needed_talk_power'] = $_POST['edit_channel_needed_talk_power'];
				}
				if($tsAdmin->getElement('success', $tsAdmin->channelEdit($_POST['channel_edit_hidden_cid'],$data))) {
					echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
					echo "Der Channel ".$_POST['channel_edit_hidden_channel_name']." wurde erfolgreich bearbeitet!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				} else {
					echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
					echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
					echo "Der Channel ".$_POST['channel_edit_hidden_channel_name']." konnte nicht bearbeitet werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
					echo "</div>";
				}
			}

			$channels = $tsAdmin->channelList();
			$servergroups = $tsAdmin->serverGroupList();
			$channelgroups = $tsAdmin->channelGroupList();

            if($_POST['channel_edit'] || $_POST['channel_pw_edit']) {

				if($_POST['channel_edit']) {
					$channelInfo = $tsAdmin->channelInfo($_POST['hidden_cid']);
                    ?>
                    <h3>Channel bearbeiten</h3>
                    <form method="post" action="index.php?site=viewer" name="form_channel_edit">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="edit_channelname" name="edit_channelname" placeholder="<?php echo $channelInfo['data']['channel_name']; ?>" value="<?php echo $channelInfo['data']['channel_name']; ?>">
                            <label for="edit_channelname">Channelname</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="edit_channel_description" name="edit_channel_description" placeholder="<?php echo $channelInfo['data']['channel_description']; ?>" value="<?php echo $channelInfo['data']['channel_description']; ?>">
                            <label for="edit_channel_description">Beschreibung</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="edit_codec" name="edit_codec" aria-label="Floating label select example">
                            <?php
                                if($channelInfo['data']['channel_codec'] == 0) {
                                    ?>
                                    <option selected>Speex Schmalband</option>
                                    <option>Speex Breitband</option>
                                    <option>Speex Ultra-Breitband</option>
                                    <option>CELT Mono</option>
                                    <option>Opus Voice</option>
                                    <option>Opus Music</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec'] == 1) {
                                    ?>
                                    <option>Speex Schmalband</option>
                                    <option selected>Speex Breitband</option>
                                    <option>Speex Ultra-Breitband</option>
                                    <option>CELT Mono</option>
                                    <option>Opus Voice</option>
                                    <option>Opus Music</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec'] == 2) {
                                    ?>
                                    <option>Speex Schmalband</option>
                                    <option>Speex Breitband</option>
                                    <option selected>Speex Ultra-Breitband</option>
                                    <option>CELT Mono</option>
                                    <option>Opus Voice</option>
                                    <option>Opus Music</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec'] == 3) {
                                    ?>
                                    <option>Speex Schmalband</option>
                                    <option>Speex Breitband</option>
                                    <option>Speex Ultra-Breitband</option>
                                    <option selected>CELT Mono</option>
                                    <option>Opus Voice</option>
                                    <option>Opus Music</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec'] == 4) {
                                    ?>
                                    <option>Speex Schmalband</option>
                                    <option>Speex Breitband</option>
                                    <option>Speex Ultra-Breitband</option>
                                    <option>CELT Mono</option>
                                    <option selected>Opus Voice</option>
                                    <option>Opus Music</option>
                                    <?php
                                } else {
                                    ?>
                                    <option>Speex Schmalband</option>
                                    <option>Speex Breitband</option>
                                    <option>Speex Ultra-Breitband</option>
                                    <option>CELT Mono</option>
                                    <option>Opus Voice</option>
                                    <option selected>Opus Music</option>
                                    <?php
                                }
                            ?>
                            </select>
                            <label for="edit_codec">Codec</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="edit_codec_quality" name="edit_codec_quality" aria-label="Floating label select example">
                            <?php
                                if($channelInfo['data']['channel_codec_quality'] == 0) {
                                    ?>
                                    <option selected>2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 1) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option selected>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 2) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option selected>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 3) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option selected>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 4) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option selected>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 5) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option selected>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 6) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option selected>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 7) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option selected>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 8) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option selected>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } elseif($channelInfo['data']['channel_codec_quality'] == 9) {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option selected>7.23 KiB/s</option>
                                    <option>7.71 KiB/s</option>
                                    <?php
                                } else {
                                    ?>
                                    <option >2.73 KiB/s</option>
                                    <option>3.22 KiB/s</option>
                                    <option>3.71 KiB/s</option>
                                    <option>4.20 KiB/s</option>
                                    <option>4.74 KiB/s</option>
                                    <option>5.22 KiB/s</option>
                                    <option>5.71 KiB/s</option>
                                    <option>6.20 KiB/s</option>
                                    <option>6.74 KiB/s</option>
                                    <option>7.23 KiB/s</option>
                                    <option selected>7.71 KiB/s</option>
                                    <?php
                                }
                            ?>
                            </select>
                            <label for="edit_codec_quality">Codec Qualität</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="edit_channel_needed_talk_power" name="edit_channel_needed_talk_power" placeholder="<?php echo $channelInfo['data']['channel_needed_talk_power']; ?>" value="<?php echo $channelInfo['data']['channel_needed_talk_power']; ?>">
                            <label for="edit_channel_needed_talk_power">Talk Power</label>
                        </div>
                        <input type="hidden" name="channel_edit_hidden_channel_name" value="<?php echo $_POST['hidden_channel_name']; ?>">
                        <input type="hidden" name="channel_edit_hidden_cid" value="<?php echo $_POST['hidden_cid']; ?>">
                        <input type="submit" class="btn btn-success" name="button_channel_edit" value="Ändern">
                        <input type="submit" class="btn btn-danger" name="button_channel_edit_abort" value="Abbrechen">
                    </form>
                    <?php
                }
                
                if($_POST['channel_pw_edit']) {
                    $channelInfo = $tsAdmin->channelInfo($_POST['hidden_cid']);
                    ?>
                    <h3>Passwort ändern</h3>
                    <form method="post" action="index.php?site=viewer" name="form_channel_pw_edit">
                        <div class="form-floating mb-3">
                            <?php
                            if($channelInfo['data']['channel_password'] == "") {
                                echo "<input type=\"password\" class=\"form-control\" id=\"edit_password\" placeholder=\"Passwort\" name=\"edit_password\">";
                                echo "<label for=\"edit_password\">Passwort</label>";
                            } else {
                                echo "<input type=\"password\" class=\"form-control\" id=\"edit_password\" placeholder=\"Passwort\" value=\"".$channelInfo['data']['channel_password']." (verschl&uuml;sselt)\" name=\"edit_password\">";
                                echo "<label for=\"edit_password\">Passwort</label>";
                            }
                            ?>
                        </div>
                        <input type="hidden" name="pw_edit_hidden_cid" value="<?php echo $_POST['hidden_cid']; ?>">
                        <button type="button" class="btn btn-dark" onclick="myFunction()">Passwort anzeigen</button>
                        <input type="submit" class="btn btn-success" name="button_channel_pw_edit" value="Ändern">
                        <?php
                            if(!empty($channelInfo['data']['channel_password'])) {
                                ?>
                                <input type="submit" class="btn btn-danger" name="button_channel_pw_delete" value="Passwort löschen">
                            <?php
                            }
                        ?>
                        <input type="submit" class="btn btn-danger" name="button_channel_pw_edit_abort" value="Abbrechen">
                    </form>
                    <?php
                }

            } else {

            ?>

                <div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasChannelAdd" aria-controls="offcanvasChannelAdd">Channel erstellen</button></div>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasChannelAdd" aria-labelledby="offcanvasChannelAddLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasChannelAddLabel"><i class="bi bi-plus-circle-fill"></i> Channel erstellen</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div>
                            Es wird ein neuer Channel erstellt.
                        </div>
                        <div class="mt-3">
                            <form method="post" action="index.php?site=viewer" name="form_channel_add" id="form_channel_add">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="channelname" name="channelname" placeholder="Channelname">
                                    <label for="channelname">Channelname</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Beschreibung">
                                    <label for="description">Beschreibung</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="channelpassword" name="channelpassword" placeholder="Passwort">
                                    <label for="channelpassword">Passwort (optional)</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="permanent" name="permanent" aria-label="Floating label select example">
                                        <option select>Ja</option>
                                        <option>Nein</option>
                                    </select>
                                    <label for="permanent">Permanent</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="codec" name="codec" aria-label="Floating label select example">
                                        <option>Speex Schmalband</option>
                                        <option>Speex Breitband</option>
                                        <option>Speex Ultra-Breitband</option>
                                        <option>CELT Mono</option>
                                        <option selected>Opus Voice</option>
                                        <option>Opus Music</option>
                                    </select>
                                    <label for="codec">Codec</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="codec_quality" name="codec_quality" aria-label="Floating label select example">
                                        <option>2.73 KiB/s</option>
                                        <option>3.22 KiB/s</option>
                                        <option>3.71 KiB/s</option>
                                        <option>4.20 KiB/s</option>
                                        <option>4.74 KiB/s</option>
                                        <option>5.22 KiB/s</option>
                                        <option selected>5.71 KiB/s</option>
                                        <option>6.20 KiB/s</option>
                                        <option>6.74 KiB/s</option>
                                        <option>7.23 KiB/s</option>
                                        <option>7.71 KiB/s</option>
                                    </select>
                                    <label for="codec_quality">Codec Qualität</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="parentchannel" name="parentchannel" aria-label="Floating label select example">
                                        <option selected>Kein übergeordneter Channel</<option>
                                        <?php
                                            foreach($channels['data'] as $channel) {
                                                //$channelInfo = $tsAdmin->channelInfo($channel['cid']);
                                                echo "<option value=\"".$channel['cid']."\">[".$channel['cid']."] ".$channel['channel_name']."</option>";
                                            }
                                        ?>
                                    </select>
                                    <label for="parentchannel">Einordnen nach</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="talk_power" name="talk_power" placeholder="0" value="0">
                                    <label for="talk_power">Talk Power</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="modify_power" name="modify_power" placeholder="75" value="75">
                                    <label for="modify_power">Modify Power</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="delete_power" name="delete_power" placeholder="75" value="75">
                                    <label for="delete_power">Delete Power</label>
                                </div>
                                <input type="submit" class="btn btn-success" value="Erstellen" name="button_channel_add">
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">CID</th>
                                <th scope="col">Name</th>
                                <th scope="col" class="text-end">Aktion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($channels['data'] as $channel) {
                                echo "<tr>";
                                    echo "<td>[".$channel['cid']."]</td>";
                                    echo "<td>";
                                        $channelInfo = $tsAdmin->channelInfo($channel['cid']); // Channel Info abfragen
                                        $channelClientList = $tsAdmin->channelClientList($channel['cid'], "-groups"); // Clients innerhalb des Channels inkl. der Gruppen abfragen
                                        #ABFRAGE CLIENTANZAHL FÜR TOGGLE CLIENTS
                                        if($channel['total_clients'] != 0) {
                                            #CLIENTS VORHANDEN, TOGGLE WIRD ANGEZEIGT
                                            #EINRÜCKEN VON SUBCHANNELS
                                            if($channel['pid'] > 0) {
                                                echo "- - - <a data-bs-toggle=\"collapse\" href=\"#collapse".$channel['cid']."\">".$channel['channel_name']."</a>";
                                            } else {
                                                echo "<a data-bs-toggle=\"collapse\" href=\"#collapse".$channel['cid']."\">".$channel['channel_name']."</a>";
                                            }
                                            #MARKIERUNG DES DEFAULT CHANNELS
                                            if($channelInfo['data']['channel_flag_default'] == 1) {
                                                echo " <i class=\"bi bi-check-circle-fill\"></i>";
                                            }
                                            #ABFRAGE NACH CHANNELPASSWORT
                                            if($channelInfo['data']['channel_flag_password'] == 1) {
                                                echo " <i class=\"bi bi-lock-fill\">";
                                            }
                                            #CHANNEL MODERIERT ODER NICHT
                                            if($channelInfo['data']['channel_needed_talk_power'] > 0) {
                                                echo " <i class=\"bi bi-volume-mute-fill\"></i>";
                                            }
                                            #ABFRAGE DER CHANNELICONS
                                            if($tsAdmin->getElement('success', $channelIcon = $tsAdmin->channelGetIconByChannelID($channel['cid']))) {
                                                echo " <img src=\"data:image/png;base64,".$channelIcon['data']."\" />";
                                            }
                                            #AUSGABE DER AKTIVEN CLIENTS IM CHANNEL
                                            echo " <em>(".$channel['total_clients']." User online)</em>";
                                            #AUSGABE DES TOGGLES
                                            echo "<div class=\"collapse\" id=\"collapse".$channel['cid']."\">";
                                                #AUSGABE DER CLIENTS IM CHANNEL
                                                foreach($channelClientList['data'] as $channelClients) {
                                                    $clientInfo = $tsAdmin->clientInfo($channelClients['clid']);
                                                    $toggle = $clientInfo['data']['client_version']." ".$clientInfo['data']['client_platform'];
                                                    $i = 0; // Laufvariable für Ausgabe der Servergruppenicons
                                                    #EINRÜCKEN DER CLIENTS IM SUBCHANNEL
                                                    if($channel['pid'] > 0) {
                                                        #SUBCHANNEL CLIENTS WERDEN EINGERÜCKT
                                                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                        $sgroups = explode(",",$channelClients['client_servergroups']);
                                                        #AUSGABE DER SERVERGRUPPEN ICONS VOR DEM NAMEN
                                                        foreach($servergroups['data'] as $servergroup) {
                                                            if($servergroup['sgid'] == $sgroups[$i]) {
                                                                if($servergroup['name'] != "Guest") {
                                                                    echo "<span class=\"badge bg-dark\">".$servergroup['name']."</span> ";
                                                                }
                                                                #if($tsAdmin->getElement('success', $servergroupicon = $tsAdmin->serverGroupGetIconBySGID($sgroups[$i]))) {
                                                                #	echo "<img src=\"data:image/png;base64,".$servergroupicon['data']."\" /> ";
                                                                #}
                                                                $i++;                                        
                                                            }
                                                        }
                                                        #AUSGABE DER CHANNELGRUPPEN ICONS VOR DEM NAMEN
                                                        foreach($channelgroups['data'] as $channelgroup) {
                                                            if($channelgroup['cgid'] == $channelClients['client_channel_group_id']) {
                                                                if($channelgroup['name'] != "Guest") {
                                                                    echo "<span class=\"badge bg-warning text-dark\">".$channelgroup['name']."</span> ";
                                                                }
                                                                #if($tsAdmin->getElement('success', $channelgroupicon = $tsAdmin->channelGroupGetIconByCGID($channelClients['client_channel_group_id']))) {
                                                                #	echo "<img src=\"data:image/png;base64,".$channelgroupicon['data']."\" /> ";
                                                                #}
                                                            }
                                                        }
                                                        if($clientInfo['data']['client_input_muted'] == 1) {
                                                            echo " <i class=\"bi bi-mic-mute-fill\"></i>";
                                                        } else {
                                                            if($clientInfo['data']['client_input_hardware'] == 1) {
                                                                echo " <i class=\"bi bi-mic-fill\"></i>";
                                                            }
                                                        }
                                                        if($clientInfo['data']['client_output_muted'] == 1) {
                                                            echo " <i class=\"bi bi-volume-mute-fill\"></i> ";
                                                        } else {
                                                            if($clientInfo['data']['client_output_hardware'] == 1) {
                                                                echo " <i class=\"bi bi-volume-up-fill\"></i> ";
                                                            }
                                                        }
                                                        #AUSGABE DES NAMEN INKLUSIVE LINK ZUR USERDETAIL SEITE
                                                        echo "<a data-bs-toggle=\"tooltip\" data-bs-placement=\"right\" title=\"".$toggle."\" href=\"index.php?site=userdetail&cldbid=".$channelClients['client_database_id']."\">".$channelClients['client_nickname']."</a><br>";
                                                    } else {
                                                        #KEIN SUBCHANNEL, KEIN EINRÜCKEN DER CLIENTS
                                                        $sgroups = explode(",",$channelClients['client_servergroups']);
                                                        #AUSGABE DER SERVERGRUPPEN ICONS VOR DEM NAMEN
                                                        foreach($servergroups['data'] as $servergroup) {
                                                            if($servergroup['sgid'] == $sgroups[$i]) {
                                                                if($servergroup['name'] != "Guest") {
                                                                    echo "<span class=\"badge bg-dark\">".$servergroup['name']."</span> ";
                                                                }
                                                                #if($tsAdmin->getElement('success', $servergroupicon = $tsAdmin->serverGroupGetIconBySGID($sgroups[$i]))) {
                                                                #	echo "<img src=\"data:image/png;base64,".$servergroupicon['data']."\" /> ";
                                                                #}
                                                                $i++;                                        
                                                            }
                                                        }
                                                        #AUSGABE DER CHANNELGRUPPEN ICONS VOR DEM NAMEN
                                                        foreach($channelgroups['data'] as $channelgroup) {
                                                            if($channelgroup['cgid'] == $channelClients['client_channel_group_id']) {
                                                                if($channelgroup['name'] != "Guest") {
                                                                    echo "<span class=\"badge bg-warning text-dark\">".$channelgroup['name']."</span> ";
                                                                }
                                                                #if($tsAdmin->getElement('success', $channelgroupicon = $tsAdmin->channelGroupGetIconByCGID($channelClients['client_channel_group_id']))) {
                                                                #	echo "<img src=\"data:image/png;base64,".$channelgroupicon['data']."\" /> ";
                                                                #}
                                                            }
                                                        }
                                                        if($clientInfo['data']['client_input_muted'] == 1) {
                                                            echo " <i class=\"bi bi-mic-mute-fill\"></i>";
                                                        } else {
                                                            if($clientInfo['data']['client_input_hardware'] == 1) {
                                                                echo " <i class=\"bi bi-mic-fill\"></i>";
                                                            }
                                                        }
                                                        if($clientInfo['data']['client_output_muted'] == 1) {
                                                            echo " <i class=\"bi bi-volume-mute-fill\"></i> ";
                                                        } else {
                                                            if($clientInfo['data']['client_output_hardware'] == 1) {
                                                                echo " <i class=\"bi bi-volume-up-fill\"></i> ";
                                                            }
                                                        }
                                                        #AUSGABE DES NAMEN INKLUSIVE LINK ZUR USERDETAIL SEITE
                                                        echo "<a data-bs-toggle=\"tooltip\" data-bs-placement=\"right\" title=\"".$toggle."\" href=\"index.php?site=userdetail&cldbid=".$channelClients['client_database_id']."\">".$channelClients['client_nickname']."</a><br>";
                                                    }
                                                }
                                            echo "</div>";
                                        } else {
                                            #KEINE CLIENTS VORHANDEN, KEIN TOGGLE
                                            if($channel['pid'] > 0) {
                                                echo "- - - ".$channel['channel_name']."";
                                            } else {
                                                    echo $channel['channel_name'];
                                            }
                                            #MARKIERUNG DES DEFAULT CHANNELS
                                            if($channelInfo['data']['channel_flag_default'] == 1) {
                                                echo " <i class=\"bi bi-check-circle-fill\"></i>";
                                            }
                                            #ABFRAGE NACH CHANNELPASSWORT
                                            if($channelInfo['data']['channel_flag_password'] == 1) {
                                                echo " <i class=\"bi bi-lock-fill\">";
                                            }
                                            #CHANNEL MODERIERT ODER NICHT
                                            if($channelInfo['data']['channel_needed_talk_power'] > 0) {
                                                echo " <i class=\"bi bi-volume-mute-fill\"></i>";
                                            }
                                            #ABFRAGE DER CHANNELICONS
                                            if($tsAdmin->getElement('success', $channelIcon = $tsAdmin->channelGetIconByChannelID($channel['cid']))) {
                                                echo " <img src=\"data:image/png;base64,".$channelIcon['data']."\" />";
                                            }
                                        }
                                    echo "</td>";
                                    echo "<td class=\"text-end\">";
                                        echo "<form method=\"post\" action=\"index.php?site=viewer\" name=\"channel_edit\">
                                            <input type=\"hidden\" name=\"hidden_cid\" value=".$channel['cid'].">
                                            <input type=\"hidden\" name=\"hidden_channel_name\" value=".$channel['channel_name'].">
                                            <input type=\"submit\" class=\"btn btn-sm btn-primary\" name=\"channel_edit\" value=\"Bearbeiten\">
                                            <input type=\"submit\" class=\"btn btn-sm btn-dark\" name=\"channel_pw_edit\" value=\"Passwort\">
                                            <a href=\"index.php?site=permissions&cid=".$channel['cid']."\" class=\"btn btn-sm btn-warning\" role=\"button\">Rechte</a>
                                            <input type=\"submit\" class=\"btn btn-sm btn-danger\" name=\"button_channel_delete\" value=\"Löschen\">";
                                        echo "</form>";
                                    echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tobdy>
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