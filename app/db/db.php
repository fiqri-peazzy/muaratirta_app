<?php

include(ROOT_PATH . "/app/db/conn.php");
session_start();

function executeQuery($sql, $data)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}

function addOrderByClause($sql, $orderBy)
{
    if (!empty($orderBy)) {
        $sql .= " ORDER BY $orderBy DESC";
    }
    return $sql;
}

function selectAll($table, $conditions = [], $orderBy = null)
{
    global $conn;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $sql = addOrderByClause($sql, $orderBy);

        $stmt = $conn->prepare($sql);

        $stmt->execute();
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    } else {
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i == 0) {
                $sql = $sql . " WHERE $key=?";
            } else {
                $sql = $sql . " AND $key=?";
            }
            $i++;
        }
        $sql = addOrderByClause($sql, $orderBy);

        $stmt = executeQuery($sql, $conditions);
        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $records;
    }
}

function dd($value)
{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}
function selectOne($table, $conditions)
{
    global $conn;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i == 0) {
            $sql = $sql . " WHERE $key=?";
        } else {
            $sql = $sql . " AND $key=?";
        }
        $i++;
    }
    $sql = $sql . " LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    $records = $stmt->get_result()->fetch_assoc();
    return $records;
}

function create($table, $data)
{
    global $conn;
    // $sql = "INSERT INTO users SET username=?, admin=?, email=?"
    $sql = "INSERT INTO $table SET";
    // SET THE DYNAMIC QUERY
    $i = 0;
    foreach ($data as $key => $value) {
        if ($i == 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    // EXECUTE THE QUERY
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

function update($table, $id, $data)
{
    global $conn;
    // $sql = "UPDATE users SET username=?, admin=?, email=?, password=? WHERE id=?"
    $sql = "UPDATE $table SET";
    // SET THE DYNAMIC QUERY
    $i = 0;
    foreach ($data as $key => $value) {
        if ($i == 0) {
            $sql = $sql . " $key=?";
        } else {
            $sql = $sql . ", $key=?";
        }
        $i++;
    }
    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;
    // EXECUTE THE QUERY
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}

function deleteF($table, $id)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE id=?";
    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;
}

function fetchDataByRange($selectedRange)
{
    global $conn;
    switch ($selectedRange) {
        case '7':
            $dateRange = "WHERE created_at >= CURDATE() - INTERVAL 7 DAY";
            break;
        case '30':
            $dateRange = "WHERE created_at >= CURDATE() - INTERVAL 30 DAY";
            break;
        case '1':
            $dateRange = "WHERE created_at >= CURDATE() - INTERVAL 1 DAY";
            break;
        default:
            $dateRange = "";
            break;
    }

    $sql = "SELECT * FROM pengaduan " . $dateRange;
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function getUser()
{
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $user_id = selectOne('users', ['id' => $id]);
        return $user_id;
    } else {
        header('Location:' . BASE_URL . '/login');
    }
}