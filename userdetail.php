<?php
if(isset($_SESSION['loggedin'])) {
    $tsAdmin->selectServer($_SESSION['vserver_port']);
    if(isset($_GET['cldbid']) && $_GET['cldbid'] != "") {

        $cldbid = $_GET['cldbid'];

        function formatSeconds( $seconds )
        {
          $hours = 0;
          $milliseconds = str_replace( "0.", '', $seconds - floor( $seconds ) );
        
          if ( $seconds > 3600 )
          {
            $hours = floor( $seconds / 3600 );
          }
          $seconds = $seconds % 3600;
        
        
          return str_pad( $hours, 2, '0', STR_PAD_LEFT )
               . gmdate( ':i:s', $seconds )
               . ($milliseconds ? ".$milliseconds" : '')
          ;
        }
            
        if($_POST['button_send_poke']) {
            if($tsAdmin->getElement('success', $tsAdmin->clientPoke($_POST['hidden_clid'],$_POST['poke']))) {
                echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
                echo "Die Nachricht wurde erfolgreich an ".$_POST['hidden_client_nickname']." gesendet!";
                echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                echo "</div>";
            } else {
                echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
                echo "Die Nachricht konnte nicht an ".$_POST['hidden_client_nickname']." gesendet werden!";
                echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                echo "</div>";
            }
        }
        
        if($_POST['button_kick_client'] || $_POST['button_ban_client']) {

            if($_POST['button_kick_client']) {
                $kickMode = "server";
                if($tsAdmin->getElement('success', $tsAdmin->clientKick($_POST['hidden_clid'],$kickMode,$_POST['kickmsg']))) {
                    echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                    echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
                    echo "User ".$_POST['hidden_client_nickname']." wurde erfolgreich vom Server gekickt!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                    echo "</div>";
                } else {
                    echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                    echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
                    echo "User ".$_POST['hidden_client_nickname']." konnte nicht vom Server gekickt werden!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                    echo "</div>";
                }
                header("refresh:3;url=index.php?site=viewer");
            }

            if($_POST['button_ban_client']) {
                if($_POST['select_duration'] != "permanent" && $_POST['duration_count'] == 0) {
                    echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                    echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
                    echo "User ".$_POST['hidden_client_nickname']." konnte nicht vom Server gebannt werden. Es wurde keine korrekte Dauer eingegeben!";
                    echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                    echo "</div>";
                } else {
                    if($_POST['select_duration'] == "permanent") {
                        $time = 0;
                    }
                    if($_POST['select_duration'] == "Sekunden") {
                        $time = $_POST['duration_count'];
                    }
                    if($_POST['select_duration'] == "Minuten") {
                        $time = $_POST['duration_count']*60;
                    }
                    if($_POST['select_duration'] == "Stunden") {
                        $time = $_POST['duration_count']*3600;
                    }
                    if($_POST['select_duration'] == "Tage") {
                        $time = $_POST['duration_count']*86400;
                    }
                    if($tsAdmin->getElement('success', $tsAdmin->banAddByUid($_POST['hidden_cluid'],$time,$_POST['banreason']))) {
                        if($_POST['select_duration'] == "permanent") {
                            echo "<div class=\"alert alert-success d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                            echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Success:\"><use xlink:href=\"#check-circle-fill\"/></svg>";
                            echo "User ".$_POST['hidden_client_nickname']." wurde erfolgreich ".$_POST['select_duration']." vom Server gebannt!";
                            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                            echo "</div>";
                        } else {
                            echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                            echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
                            echo "User ".$_POST['hidden_client_nickname']." wurde erfolgreich f&uuml;r ".$_POST['duration_count']." ".$_POST['select_duration']." vom Server gebannt!";
                            echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div class=\"alert alert-danger d-flex align-items-center alert-dismissible fade show\" role=\"alert\">";
                        echo "<svg class=\"bi flex-shrink-0 me-2\" width=\"24\" height=\"24\" role=\"img\" aria-label=\"Danger:\"><use xlink:href=\"#exclamation-triangle-fill\"/></svg>";
                        echo "User ".$_POST['hidden_client_nickname']." konnte nicht vom Server gebannt werden!";
                        echo "<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>";
                        echo "</div>";
                    }
                }
                header("refresh:3;url=index.php?site=viewer");
            }

        } else {

            if($tsAdmin->getElement('success', $clientDbInfo = $tsAdmin->clientDbInfo($_GET['cldbid']))) {
                $clientGetIds = $tsAdmin->clientGetIds($clientDbInfo['data']['client_unique_identifier']);
                $clientInfo = $tsAdmin->clientInfo($clientGetIds['data']['0']['clid']);
                $servergroups = $tsAdmin->serverGroupList();
                $channelgroups = $tsAdmin->channelGroupList();
                $i = 0;
                #print_r($clientInfo);

                ?>

                <div class="d-inline-flex mb-3"><a href="index.php?site=viewer" class="btn btn-danger" role="button">Zurück</a></div>
                <div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasKickClient" aria-controls="offcanvasKickClient"><?php echo $clientInfo['data']['client_nickname']; ?> kicken</button></div>
                <div class="d-inline-flex mb-3"><button type="button" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBanClient" aria-controls="offcanvasBanClient"><?php echo $clientInfo['data']['client_nickname']; ?> bannen</button></div>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasKickClient" aria-labelledby="offcanvasKickClientLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasKickClientLabel"><i class="bi bi-exclamation-triangle-fill"></i> <?php echo $clientInfo['data']['client_nickname']; ?> kicken</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div>
                            tbd.
                        </div>
                        <div class="mt-3">
                            <?php
                                echo "<form method=\"post\" action=\"index.php?site=userdetail&cldbid=".$cldbid."\" name=\"form_kick_client\" id=\"form_kick_client\">
                                        <div class=\"form-floating mb-3\">
                                            <input type=\"text\" class=\"form-control\" id=\"kickmsg\" name=\"kickmsg\" maxlength=\"40\" placeholder=\"Grund\">
                                            <label for=\"kickmsg\">Grund</label>
                                        </div>
                                        <input type=\"hidden\" name=\"hidden_client_nickname\" value=\"".$clientInfo['data']['client_nickname']."\">
                                        <input type=\"hidden\" name=\"hidden_clid\" value=\"".$clientGetIds['data']['0']['clid']."\">
                                        <input type=\"submit\" class=\"btn btn-success\" name=\"button_kick_client\" value=\"".$clientInfo['data']['client_nickname']." kicken\">
                                    </form>";
                            ?>
                        </div>
                    </div>
                </div>

                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasBanClient" aria-labelledby="offcanvasBanClientLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasBanClientLabel"><i class="bi bi-exclamation-triangle-fill"></i> <?php echo $clientInfo['data']['client_nickname']; ?> bannen</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div>
                            tbd.
                        </div>
                        <div class="mt-3">
                            <?php
                                echo "<form method=\"post\" action=\"index.php?site=userdetail&cldbid=".$cldbid."\" name=\"form_ban_client\" id=\"form_ban_client\">
                                        <div class=\"form-floating mb-3\">
                                            <input type=\"text\" class=\"form-control\" id=\"kickmsg\" name=\"banreason\" maxlength=\"40\" placeholder=\"Grund\">
                                            <label for=\"banreason\">Grund</label>
                                        </div>
                                        <div class=\"form-floating mb-3\">
                                            <select class=\"form-select\" id=\"select_duration\" name=\"select_duration\" aria-label=\"Floating label select example\">
                                                <option selected>permanent</option>
                                                <option>Sekunden</option>
                                                <option>Minuten</option>
                                                <option>Stunden</option>
                                                <option>Tage</option>
                                            </select>
                                            <label for=\"select_duration\">Dauer</label>
                                        </div>
                                        <div class=\"form-floating mb-3\">
                                            <input type=\"number\" class=\"form-control\" id=\"duration_count\" name=\"duration_count\" placeholder=\"0\" value=\"0\">
                                            <label for=\"duration_count\">Anzahl</label>
                                        </div>
                                        <input type=\"hidden\" name=\"hidden_client_nickname\" value=\"".$clientInfo['data']['client_nickname']."\">
                                        <input type=\"hidden\" name=\"hidden_cluid\" value=\"".$clientDbInfo['data']['client_unique_identifier']."\">
                                        <input type=\"submit\" class=\"btn btn-success\" name=\"button_ban_client\" value=\"".$clientInfo['data']['client_nickname']." bannen\">
                                    </form>";
                            ?>
                        </div>
                    </div>
                </div>

                <h2>
                    <?php
                        echo $clientInfo['data']['client_nickname'];
                        if($clientInfo['data']['client_input_muted'] == 1) {
                            echo " <i class=\"bi bi-mic-mute-fill\"></i>";
                        } else {
                            if($clientInfo['data']['client_input_hardware'] == 1) {
                                echo " <i class=\"bi bi-mic-fill\"></i>";
                            }
                        }
                        if($clientInfo['data']['client_output_muted'] == 1) {
                            echo " <i class=\"bi bi-volume-mute-fill\"></i>";
                        } else {
                            if($clientInfo['data']['client_output_hardware'] == 1) {
                                echo " <i class=\"bi bi-volume-up-fill\"></i>";
                            }
                        }
                    ?>               
                </h2>

                <h3>Anstupsen</h3>
                <form method="post" action="index.php?site=userdetail&cldbid=<?php echo $cldbid; ?>" name="form_poke">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Nachricht" id="poke" style="height: 100px" name="poke"></textarea>
                        <label for="poke">Nachricht</label>
                    </div>
                    <input type="hidden" name="hidden_client_nickname" value="<?php echo $clientInfo['data']['client_nickname']; ?>">
                    <input type="hidden" name="hidden_clid" value="<?php echo $clientGetIds['data']['0']['clid']; ?>">
                    <input type="submit" class="btn btn-success mb-3" value="Senden" name="button_send_poke">
                </form>

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
                                <td class="w-25">Database ID</td>
                                <td class="w-75"><?php echo $clientInfo['data']['client_database_id']; ?></td>
                            </tr>
                            <tr>
                                <td>UID</td>
                                <td><?php echo $clientInfo['data']['client_unique_identifier']; ?></td>
                            </tr>
                            <tr>
                                <td>Erstellt</td>
                                <td><?php echo date("d.m.Y - H:i", $clientInfo['data']['client_created']); ?></td>
                            </tr>
                            <tr>
                                <td>Zuletzt online</td>
                                <td><?php echo date("d.m.Y - H:i", $clientInfo['data']['client_lastconnected']); ?></td>
                            </tr>
                            <tr>
                                <td>Summe Verbindungen</td>
                                <td><?php echo $clientInfo['data']['client_totalconnections']; ?></td>
                            </tr>
                            <tr>
                                <td>Version</td>
                                <td><?php echo $clientInfo['data']['client_version']; ?></td>
                            </tr>
                            <tr>
                                <td>Plattform</td>
                                <td><?php echo $clientInfo['data']['client_platform']; ?></td>
                            </tr>
                            <tr>
                                <td>Land</td>
                                <?php
                                    if($clientInfo['data']['client_country'] != "") {
                                        echo "<td><img src=\"images/flags/".$clientInfo['data']['client_country'].".png\" alt=\"".$clientInfo['data']['client_country']."\" title=\"".$clientInfo['data']['client_country']."\" /></td>";
                                    } else {
                                        echo "<td><img src=\"images/flags/rainbow.png\" alt=\"\" /></td>";
                                    }
                                ?>
                            </tr>
                            <tr>
                                <td>Online seit</td>
                                <td>
                                    <?php
                                        $onlineseconds = $clientInfo['data']['connection_connected_time']/1000;
                                        echo formatSeconds($onlineseconds);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Aktuelle IP</td>
                                <td><?php echo $clientInfo['data']['connection_client_ip']; ?></td>
                            </tr>
                            <tr>
                                <td>Servergruppen</td>
                                <td>
                                    <?php
                                    $sgroups = explode(",",$clientInfo['data']['client_servergroups']);
                                    foreach($servergroups['data'] as $servergroup) {
                                        if($servergroup['sgid'] == $sgroups[$i]) {
                                            if($i > 0) {
                                                #if($tsAdmin->getElement('success', $servergroupicon = $tsAdmin->serverGroupGetIconBySGID($sgroups[$i]))) {
                                                #    echo ", <img src=\"data:image/png;base64,".$servergroupicon['data']."\" /> <span class=\"label label-primary\">".$servergroup['name']."</span>";
                                                #}
                                                echo " <span class=\"badge bg-dark\">".$servergroup['name']."</span>";
                                                $i++; 
                                            } else {
                                                #if($tsAdmin->getElement('success', $servergroupicon = $tsAdmin->serverGroupGetIconBySGID($sgroups[$i]))) {
                                                #    echo "<img src=\"data:image/png;base64,".$servergroupicon['data']."\" /> ";
                                                #}
                                                echo "<span class=\"badge bg-dark\">".$servergroup['name']."</span>";
                                                $i++;                                        
                                            }
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Channelgruppen</td>
                                <td>
                                    <?php
                                    foreach($channelgroups['data'] as $channelgroup) {
                                        if($channelgroup['cgid'] == $clientInfo['data']['client_channel_group_id']) {
                                            #if($tsAdmin->getElement('success', $channelgroupicon = $tsAdmin->channelGroupGetIconByCGID($clientInfo['data']['client_channel_group_id']))) {
                                            #    echo "<img src=\"data:image/png;base64,".$channelgroupicon['data']."\" /> ";
                                            #}
                                            echo "<span class=\"badge bg-warning text-dark\">".$channelgroup['name']."</span>";
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Avatar</td>
                                <td>
                                    <?php
                                    //$avatar = $tsAdmin->clientAvatar($clientInfo['data']['client_unique_identifier']);
                                    if($tsAdmin->getElement('success', $avatar = $tsAdmin->clientAvatar($clientInfo['data']['client_unique_identifier']))) {
                                        echo "<img src=\"data:image/png;base64,".$avatar["data"]."\" />";
                                    } else {
                                        echo "<i>Kein Avatar vorhanden</i>";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <?php
                    
            } else {
                if($_GET['cldbid'] == 1) {
                    ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Der "serveradmin" kann im Detail nicht angeschaut werden.
                        </div>
                    </div>
                    <?php
                    header("refresh:3;url=index.php?site=viewer");
                } else {
                    ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Der User ist derzeit nicht online.
                        </div>
                    </div>
                    <?php
                    header("refresh:3;url=index.php?site=viewer");
                }
            }
        }
    } else {
        ?>
        <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
            <strong>Es wurde kein User ausgew&auml;hlt!</strong>
        </div>
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
