<?php
include 'database.php';

$sql = "SELECT adventure, COUNT(*) AS count FROM booking GROUP BY adventure";
$result = $conn->query($sql);

$bookings = ["land" => 0, "water" => 0, "air" => 0];

while ($row = $result->fetch_assoc()) {
    if (in_array($row["adventure"], ["Mountain Trekking", "Forest Hiking", "Desert Safari", "Rock Climbing", "Wildlife Safari"])) {
        $bookings["land"] += $row["count"];
    } elseif (in_array($row["adventure"], ["River Rafting", "Scuba Diving", "Snorkeling", "Fishing", "Kayaking"])) {
        $bookings["water"] += $row["count"];
    } elseif (in_array($row["adventure"], ["Paragliding", "Hot Air Balloon", "Skydiving", "Bungee Jumping"])) {
        $bookings["air"] += $row["count"];
    }
}

$conn->close();
echo json_encode($bookings);
?>
