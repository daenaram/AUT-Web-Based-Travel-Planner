<?php

function searchAccommodations(PDO $pdo, array $data): array {
    $name = trim($data['accommodation_name'] ?? '');
    $type = trim($data['accommodation_type'] ?? '');
    $city = trim($data['accommodation_city'] ?? '');

    $query = 'SELECT * FROM accommodations';
    $conditions = [];
    $params = [];

    if ($name !== '') {
        $conditions[] = 'name LIKE :name';
        $params[':name'] = "%$name%";
    }

    if ($type !== '') {
        $conditions[] = 'type LIKE :type';
        $params[':type'] = "%$type%";
    }

    if ($city !== '') {
        $conditions[] = 'city LIKE :city';
        $params[':city'] = "%$city%";
    }

    if (count($conditions) > 0) {
        $query .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $query .= ' ORDER BY city ASC, price_per_night_nzd ASC';
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>