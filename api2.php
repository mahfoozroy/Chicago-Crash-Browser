<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once("pg.php");
error_reporting(0);

if(!empty($_GET)) {
	$coords = trim(urldecode($_GET["coords"]));
}

// constant for ST_Transform
$NAD83_ILLINOIS_EAST = 3435;
$WGS_84 = 4326;

$q = <<< HEREDOC
SELECT
	"collType",
	casenumber,
	"totalInjuries",
	"Total killed" as "totalKilled",
	"No injuries" as "noInjuries",
	month,
	day,
	year,
	latitude,
	longitude
FROM $table c
WHERE ST_WITHIN (
	ST_TRANSFORM(
		ST_GeomFromText('POLYGON(($1))', $WGS_84), $NAD83_ILLINOIS_EAST
	),
	ST_TRANSFORM(c.wgs84, $NAD83_ILLINOIS_EAST)
)
ORDER BY year ASC, month ASC, day ASC
HEREDOC;

if(!empty($lat) && !empty($lng)) {
	$result = pg_prepare($pg, 'coords_query', $q);
	$result = pg_execute($pg, 'coords_query', $coords);
	$total = pg_num_rows($result);
}

// output JSON
echo '{"response":{"sql":' . json_encode($q) . '},"crashes":[';
echo pg_last_error($pg);

$first = true;
$r = pg_fetch_assoc($result);
while($r=pg_fetch_assoc($result)){

    if($first) {
        $first = false;
    } else {
        echo ',';
    }
    echo json_encode($r)."\n";
}
echo ']}';

?>