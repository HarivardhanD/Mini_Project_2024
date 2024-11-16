<?php
include 'db_connection.php';

if (isset($_POST['EntryKey'])) {
    $empId = $_POST['empId'];
    $entryKey = $_POST['EntryKey'];

    // Query to check if the EntryKey matches the one in the database for the given USN
    $query = "SELECT * FROM faculty WHERE emp_id = ? AND EntryKey = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $empId, $entryKey);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // EntryKey is valid
        echo json_encode(['success' => true]);
    } else {
        // Invalid EntryKey
        echo json_encode(['success' => false, 'message' => 'No matching entry found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Entry Key not provided']);
}
?>