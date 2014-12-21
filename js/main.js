// The root URL for the RESTful services
var rootURL = "http://localhost/zaman/api/device";

var currentDevice;

// Retrieve wine list when application starts 
findAll();

// Nothing to delete in initial application state
$('#btnDelete').hide();

// Register listeners
$('#btnSearch').click(function () {
    search($('#searchKey').val());
    return false;
});

// Trigger search when pressing 'Return' on search key input field
$('#searchKey').keypress(function (e) {
    if (e.which == 13) {
        search($('#searchKey').val());
        e.preventDefault();
        return false;
    }
});

$('#btnAdd').click(function () {
    newDevice();
    return false;
});

$('#btnSave').click(function () {
    if ($('#uniqueId').val() == '')
        addDevice();
    else
        updateDevice();
    return false;
});

$('#btnDelete').click(function () {
    deleteDevice();
    return false;
});

$('#deviceList').on( 'click', 'li', function () {
    console.log("onclick");
    findById($(this).data('identity'));
});

$('#deviceList').on('click', 'li', function () {
    console.log("onclick");
    findById($(this).data('identity'));
});

// Replace broken images with generic wine bottle
$("img").error(function () {
    $(this).attr("src", "pics/generic.jpg");

});

function search(searchKey) {
    if (searchKey == '')
        findAll();
    else
        findByName(searchKey);
}

function newDevice() {
    $('#btnDelete').hide();
    currentDevice = {};
    renderDetails(currentDevice); // Display empty form
}

function findAll() {
    console.log('findAll');
    $.ajax({
        type: 'GET',
        url: rootURL,
        dataType: "json", // data type of response
        success: renderList
    });
}

function findByName(searchKey) {
    console.log('findByName: ' + searchKey);
    $.ajax({
        type: 'GET',
        url: rootURL + '/arama/' + searchKey,
        dataType: "json",
        success: renderList
    });
}

function findById(uniqueId) {
    console.log('findById: ' + uniqueId);
    $.ajax({
        type: 'GET',
        url: rootURL + '/' + uniqueId,
        dataType: "json",
        success: function (data) {
            $('#btnDelete').show();
            console.log('findById success: ' + data.name);
            currentDevice = data;
            renderDetails(currentDevice);
        }
    });
}

function addDevice() {
    console.log('addDevice');
    $.ajax({
        type: 'POST',
        contentType: 'application/json',
        url: rootURL,
        dataType: "json",
        data: formToJSON(),
        success: function (data, textStatus, jqXHR) {
            alert('Wine created successfully');
            $('#btnDelete').show();
            $('#uniqueId').val(data.uniqueId);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('addWine error: ' + textStatus);
        }
    });
}

function updateDevice() {
    console.log('updateDevice');
    $.ajax({
        type: 'PUT',
        contentType: 'application/json',
        url: rootURL + '/' + $('#uniqueId').val(),
        dataType: "json",
        data: formToJSON(),
        success: function (data, textStatus, jqXHR) {
            alert('Wine updated successfully');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('updateWine error: ' + textStatus);
        }
    });
}

function deleteDevice() {
    console.log('deleteDevice');
    $.ajax({
        type: 'DELETE',
        url: rootURL + '/' + $('#uniqueId').val(),
        success: function (data, textStatus, jqXHR) {
            alert('Device deleted successfully');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('deleteDevice error');
        }
    });
}

function renderList(data) {
    // JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
    var list = data == null ? [] : (data.device instanceof Array ? data.device : [data.device]);

    $('#deviceList li').remove();
    $.each(list, function (index, device) {
        $('#deviceList').append('<li><a href="#" data-identity="' + device.uniqueId + '">' + device.deviceName + '</a></li>');
    });
}

function renderDetails(device) {
    $('#uniqueId').val(device.uniqueId);
    $('#deviceName').val(device.deviceName);
    $('#override').val(device.override);
    $('#timeStart').val(device.timeStart);
    $('#timeEnd').val(device.timeEnd);
    $('#notes').val(device.notes);
}

// Helper function to serialize all the form fields into a JSON string
function formToJSON() {
    return JSON.stringify({
        "uniqueId": $('#uniqueId').val(),
        "deviceName": $('#deviceName').val(),
        "override": $('#override').val(),
        "timeStart": $('#timeStart').val(),
        "timeEnd": $('#timeEnd').val(),
        "notes": $('#notes').val(),
    });
}
