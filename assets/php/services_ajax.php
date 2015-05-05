<!DOCTYPE html>
<?php
	Ini_Set( 'display_errors', true );
	include '../../init.php';
	include ROOT_DIR . '/assets/php/functions.php';
	include("service.class.php");
	include("serviceSAB.class.php");
	include("serviceMinecraft.class.php");
?>
<html lang="en">
	<script>
	// Enable bootstrap tooltips
	$(function ()
	        { $("[rel=tooltip]").tooltip();
	        });
	</script>
<?php
$sabnzbdXML = simplexml_load_file('http://'.$sabnzbd_ip.':'.$sabnzbd_port.'/api?mode=qstatus&output=xml&apikey='.$sabnzbd_api);

if (($sabnzbdXML->state) == 'Downloading'):
	$timeleft = $sabnzbdXML->timeleft;
	$sabTitle = 'SABnzbd ('.$timeleft.')';
else:
	$sabTitle = 'SABnzbd';
endif;

$services = array(
	new service("Plex", $plex_port, $plex_URL, $plex_ip),
	new service("pfSense", $pfSense_port, $pfSense_URL, $pfSense_ip),
	new serviceSAB($sabTitle, $sabnzbd_port, $sabnzbd_URL, $sabnzbd_ip),
	new service("SickBeard", $sickbeard_port, $sickbeard_URL, $sickbeard_ip),
	new service("CouchPotato", $couchpotato_port, $couchpotato_URL, $couchpotato_ip),
	new service("Transmission", 9091, "http://d4rk.co:9091", "10.0.1.5"),
	new service("iTunes Server", 3689, "http://www.apple.com/itunes/"),
	//new service("Starbound Server", 21025, "http://playstarbound.com"),
	new serviceMinecraft("Vanilla", 25564, "http://minecraft.d4rk.co", "mc.d4rk.co"),
	new serviceMinecraft("Bevo Tech Pack", 25565, "http://minecraft.d4rk.co")
);
?>
<table class="center">
	<?php foreach($services as $service){ ?>
		<tr>
			<td style="text-align: right; padding-right:5px;" class="exoextralight"><?php echo $service->name; ?></td>
			<td style="text-align: left;"><?php echo $service->makeButton(); ?></td>
		</tr>
	<?php }?>
</table>