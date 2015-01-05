<?php

require 'Slim/Slim.php';

$app = new Slim();

// Zaman
$app->get('/zaman', 'getZaman');
$app->put('/zaman/1', 'updateZaman');

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
$app->delete('/score/:id/:game', 'deleteScore');

// Kullanicilar
$app->get('/user', 'getUsers');
$app->get('/user/:id', 'getUser');
$app->get('/user/arama/:query', 'findUserByName');
$app->post('/user', 'addUser');
$app->put('/user/:id', 'updateUser');
$app->delete('/user/:id', 'deleteUser');
$app->post('/login', 'login');

$app->run();

/* CIHAZLAR
 * *****************************************************************************
 */

function getZaman() {
    $sql = "SELECT * FROM zaman WHERE id=1";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $zaman = $stmt->fetchObject();
        $db = NULL;
        echo json_encode($zaman);
    } catch (Exception $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function updateZaman() {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $zaman = json_decode($body);
    $sql = "UPDATE zaman SET timeStart=:timeStart, timeEnd=:timeEnd WHERE id=1";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("timeStart", $zaman->timeStart);
        $stmt->bindParam("timeEnd", $zaman->timeEnd);
        $stmt->execute();
        $db = null;
        echo json_encode($zaman);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

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
        echo json_encode($devices);
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
        echo json_encode($devices);
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
        echo json_encode($devices);
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
    $sql = "INSERT INTO games (gameName, notes) VALUES (:gameName, :notes);";
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
    $sql = "UPDATE games SET gameName=:gameName, notes=:notes WHERE gameId=:gameId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("gameName", $game->gameName);
        $stmt->bindParam("notes", $game->notes);
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
        echo json_encode($games);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

/* SKORLAR
 * *****************************************************************************
 */

function getScores() {
    $sql = "SELECT * FROM scores ORDER BY device_unique_id";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $scores = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = NULL;
        echo json_encode($scores);
    } catch (Exception $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function getScore($device_unique_id) {
    $sql = "SELECT * FROM scores WHERE device_unique_id=:device_unique_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("device_unique_id", $device_unique_id);
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
    $score = json_decode($request->getBody());
    $sql = "INSERT INTO scores (device_unique_id, game_id, score) "
            . "VALUES (:device_unique_id, :game_id, :score);";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("device_unique_id", $score->device_unique_id);
        $stmt->bindParam("game_id", $score->game_id);
        $stmt->bindParam("score", $score->score);
        $stmt->execute();
        $db = null;
        echo json_encode($score);
    } catch (PDOException $exc) {
        //error_log($exc->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function updateScore($device_unique_id) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $score = json_decode($body);
    $sql = "UPDATE scores SET score=:score "
            . "WHERE device_unique_id=:device_unique_id AND game_id=:game_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("device_unique_id", $score->device_unique_id);
        $stmt->bindParam("game_id", $score->game_id);
        $stmt->bindParam("score", $score->score);
        $stmt->execute();
        $db = null;
        echo json_encode($score);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function deleteScore($device_unique_id, $game_id) {
    $sql = "DELETE FROM scores WHERE device_unique_id=:device_unique_id AND game_id=:game_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("device_unique_id", $score->device_unique_id);
        $stmt->bindParam("game_id", $score->game_id);
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
        echo json_encode($devices);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

/*
 * KULLANICILAR
 * *****************************************************************************
 */

function getUsers() {
    $sql = "SELECT * FROM user ORDER BY userName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = NULL;
        echo json_encode($users);
    } catch (Exception $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function getUser($userId) {
    $sql = "SELECT * FROM user WHERE userId=:userId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        $user = $stmt->fetchObject();
        $db = null;
        echo json_encode($user);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function addUser() {
    //error_log('addDevice\n', 3, '/var/tmp/php.log');
    $request = Slim::getInstance()->request();
    $user = json_decode($request->getBody());
    $sql = "INSERT INTO user (userName, userPassword, userAccess) VALUES (:userName, :userPassword, :userAccess);";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userName", $user->userName);
        $stmt->bindParam("userPassword", $user->userPassword);
        $stmt->bindParam("userAccess", $user->userAccess);
        $stmt->execute();
        $db = null;
        echo json_encode($user);
    } catch (PDOException $exc) {
        //error_log($exc->getMessage(), 3, '/var/tmp/php.log');
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function updateUser($userId) {
    $request = Slim::getInstance()->request();
    $body = $request->getBody();
    $user = json_decode($body);
    $sql = "UPDATE user SET userName=:userName, userPassword=:userPassword, userAccess=:userAccess WHERE userId=:userId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userName", $user->userName);
        $stmt->bindParam("userPassword", $user->userPassword);
        $stmt->bindParam("userAccess", $user->userAccess);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        $db = null;
        echo json_encode($user);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function deleteUser($userId) {
    $sql = "DELETE FROM user WHERE userId=:userId";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userId", $userId);
        $stmt->execute();
        $db = null;
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function findUserByName($query) {
    $sql = "SELECT * FROM user WHERE UPPER(userName) LIKE :query ORDER BY userName";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%" . $query . "%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($users);
    } catch (PDOException $exc) {
        echo '{"error":{"text":' . $exc->getMessage() . '}}';
    }
}

function login() {
    $request = Slim::getInstance()->request();
    $login = json_decode($request->getBody());
    $sql = "SELECT * FROM user WHERE userName=:userName AND userPassword=:userPassword";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userName", $login->userName);
        $stmt->bindParam("userPassword", $login->userPassword);
        $stmt->execute();
        $login = $stmt->fetchObject();
        ;
        $db = null;
        echo json_encode($login);
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
    $dbname = "timeconstraint";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

/*
 * *****************************************************************************
 */
?>