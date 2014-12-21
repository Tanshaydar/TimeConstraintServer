<?php

require 'Slim/Slim.php';

$app = new Slim();

// Cihazlar
$app->get('/device', 'getDevices');
$app->get('/device/:uniqueId', 'getDevice');
$app->get('/device/arama/:query', 'findDeviceByName');
$app->post('/device', 'addDevice');
$app->put('/device/:uniqueId', 'updateDevice');
$app->delete('/device/:uniqueId', 'deleteDevice');

// Oyunlar
$app->get('/game', 'getGames');
$app->get('/game/:id', 'getGame');
$app->get('/game/arama/:query', 'findGameByName');
$app->post('/game', 'addGame');
$app->put('/game/:id', 'updateGame');
$app->delete('/game/:id', 'deleteGame');

// Skorlar
$app->get('/score', 'getScores');
$app->get('/score/:id', 'getScore');
$app->post('/score', 'addScore');
$app->put('/score/:id', 'updateScore');
$app->delete('/score/:id', 'deleteScore');

// Kullanicilar
$app->get('/user', 'getUsers');
$app->get('/user/:id', 'getUser');
$app->get('/user/arama/:query', 'findUserByName');
$app->post('/user', 'addUser');
$app->put('/user/:id', 'updateUser');
$app->delete('/user/:id', 'deleteUser');


$app->run();

/* CIHAZLAR
 * *****************************************************************************
 */
function getDevices() {
    $sql = "SELECT * FROM device ORDER BY deviceName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $devices = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = NULL;
        echo '{"device": ' . json_encode($devices) . '}';
    } catch (Exception $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }

}

function getDevice($uniqueId) {
    $sql = "SELECT * FROM device WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $device = $stmt->fetchObject();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}


function addDevice() {
    //error_log('addDevice\n', 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $device = json_decode($request->getBody());
    $sql = "INSERT INTO device (uniqueId, deviceName, override,"
            . " timeStart, timeEnd, notes) VALUES (:uniqueId, :deviceName, :override, :timeStart, :timeEnd, :notes);";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $device->uniqueId);
        $stmt->bindParam("deviceName", $device->deviceName);
        $stmt->bindParam("override", $device->override);
        $stmt->bindParam("timeStart", $device->timeStart);
        $stmt->bindParam("timeEnd", $device->timeEnd);
        $stmt->bindParam("notes", $device->notes);
        $stmt->execute();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        //error_log($exc->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function updateDevice($uniqueId) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $device = json_decode($body);
    $sql = "UPDATE device SET deviceName=:deviceName, override=:override, timeStart=:timeStart,"
            . " timeEnd=:timeEnd, notes=:notes WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("deviceName", $device->deviceName);
        $stmt->bindParam("override", $device->override);
        $stmt->bindParam("timeStart", $device->timeStart);
        $stmt->bindParam("timeEnd", $device->timeEnd);
        $stmt->bindParam("notes", $device->notes);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function deleteDevice($uniqueId) {
    $sql = "DELETE FROM device WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $db = null;
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function findDeviceByName($query) {
    $sql = "SELECT * FROM device WHERE UPPER(deviceName) LIKE :query ORDER BY deviceName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $devices = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"device": ' . json_encode($devices) . '}';
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

/* OYUNLAR
 * *****************************************************************************
 */
function getGames() {
    $sql = "SELECT * FROM games ORDER BY gameName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $devices = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = NULL;
        echo '{"game": ' . json_encode($devices) . '}';
    } catch (Exception $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }

}

function getGame($gameId) {
    $sql = "SELECT * FROM games WHERE gameId=:gameId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("gameId", $gameId);
        $stmt->execute();
        $game = $stmt->fetchObject();
        $db = null;
        echo json_encode($game);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}


function addGame() {
    $request = Slim::getInstance()->request();
    $game = json_decode($request->getBody());
    $sql = "INSERT INTO games (gameName) VALUES (:gameName);";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("gameName", $game->gameName);
        $stmt->execute();
        $db = null;
        echo json_encode($game);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function updateGame($gameId) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $game = json_decode($body);
    $sql = "UPDATE games SET gameName=:gameName WHERE gameId=:gameId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("gameName", $game->gameName);
        $stmt->bindParam("gameId", $gameId);
        $stmt->execute();
        $db = null;
        echo json_encode($game);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function deleteGame($gameId) {
    $sql = "DELETE FROM games WHERE gameId=:gameId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("gameId", $gameId);
        $stmt->execute();
        $db = null;
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function findGameByName($query) {
    $sql = "SELECT * FROM games WHERE UPPER(gameName) LIKE :query ORDER BY gameName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $games = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"game": ' . json_encode($games) . '}';
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}
/* SKORLAR
 * *****************************************************************************
 */
function getScores() {
    $sql = "SELECT * FROM device ORDER BY deviceName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $devices = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = NULL;
        echo '{"score": ' . json_encode($devices) . '}';
    } catch (Exception $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }

}

function getScore($uniqueId) {
    $sql = "SELECT * FROM device WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $device = $stmt->fetchObject();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}


function addScore() {
    //error_log('addDevice\n', 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $device = json_decode($request->getBody());
    $sql = "INSERT INTO device (uniqueId, deviceName, override,"
            . " timeStart, timeEnd, notes) VALUES (:uniqueId, :deviceName, :override, :timeStart, :timeEnd, :notes);";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $device->uniqueId);
        $stmt->bindParam("deviceName", $device->deviceName);
        $stmt->bindParam("override", $device->override);
        $stmt->bindParam("timeStart", $device->timeStart);
        $stmt->bindParam("timeEnd", $device->timeEnd);
        $stmt->bindParam("notes", $device->notes);
        $stmt->execute();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        //error_log($exc->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function updateScore($uniqueId) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $device = json_decode($body);
    $sql = "UPDATE device SET deviceName=:deviceName, override=:override, timeStart=:timeStart,"
            . " timeEnd=:timeEnd, notes=:notes WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("deviceName", $device->deviceName);
        $stmt->bindParam("override", $device->override);
        $stmt->bindParam("timeStart", $device->timeStart);
        $stmt->bindParam("timeEnd", $device->timeEnd);
        $stmt->bindParam("notes", $device->notes);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function deleteScore($uniqueId) {
    $sql = "DELETE FROM device WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $db = null;
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function findScoreByName($query) {
    $sql = "SELECT * FROM device WHERE UPPER(deviceName) LIKE :query ORDER BY deviceName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $devices = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"score": ' . json_encode($devices) . '}';
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}


/*
 * KULLANICILAR
 * *****************************************************************************
 */
function getUsers() {
    $sql = "SELECT * FROM device ORDER BY deviceName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $devices = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = NULL;
        echo '{"user": ' . json_encode($devices) . '}';
    } catch (Exception $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }

}

function getUser($uniqueId) {
    $sql = "SELECT * FROM device WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $device = $stmt->fetchObject();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}


function addUser() {
    //error_log('addDevice\n', 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $device = json_decode($request->getBody());
    $sql = "INSERT INTO device (uniqueId, deviceName, override,"
            . " timeStart, timeEnd, notes) VALUES (:uniqueId, :deviceName, :override, :timeStart, :timeEnd, :notes);";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $device->uniqueId);
        $stmt->bindParam("deviceName", $device->deviceName);
        $stmt->bindParam("override", $device->override);
        $stmt->bindParam("timeStart", $device->timeStart);
        $stmt->bindParam("timeEnd", $device->timeEnd);
        $stmt->bindParam("notes", $device->notes);
        $stmt->execute();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        //error_log($exc->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function updateUser($uniqueId) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $device = json_decode($body);
    $sql = "UPDATE device SET deviceName=:deviceName, override=:override, timeStart=:timeStart,"
            . " timeEnd=:timeEnd, notes=:notes WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("deviceName", $device->deviceName);
        $stmt->bindParam("override", $device->override);
        $stmt->bindParam("timeStart", $device->timeStart);
        $stmt->bindParam("timeEnd", $device->timeEnd);
        $stmt->bindParam("notes", $device->notes);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $db = null;
        echo json_encode($device);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function deleteUser($uniqueId) {
    $sql = "DELETE FROM device WHERE uniqueId=:uniqueId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uniqueId", $uniqueId);
        $stmt->execute();
        $db = null;
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function findUserByName($query) {
    $sql = "SELECT * FROM device WHERE UPPER(deviceName) LIKE :query ORDER BY deviceName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $devices = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"user": ' . json_encode($devices) . '}';
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

/*
 * BAGLANTI
 * *****************************************************************************
 */

function getConnection() {
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "cellar";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
/*
 * *****************************************************************************
 */
?>