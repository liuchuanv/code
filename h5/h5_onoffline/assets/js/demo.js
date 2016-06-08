
var getRecords = 'get-records.php';
var addRecords = 'add-record.php';

//是否支持localstorage
function supports_html5_storage() {
	try{
		return 'localStorage' in window && window['localStorage'] !== null;
	}catch (e) {
		return false;
	}
}

//清除在线数据
function clearPrimaryCache(){
    localStorage.removeItem('records.user.hasRecords');
    localStorage.removeItem('records.user.records');
}
//清除离线数据 
function clearOfflineCache(){
    localStorage.removeItem('records.user.local.records');
    localStorage.removeItem('records.offline.status');
}

//通过 get-records.php 检索数据记录，并清除原来的缓存，缓存检索的记录，然后设置一个变量表明我们的可用记录。
function getRecordsFun(){
    if (!supports_html5_storage()) {
        return false;
    }

	$.getJSON(getRecords, function(data) {
		clearPrimaryCache();
		var records = [];
		records.push(data.records);
		if (records.length !== 0) {
			localStorage.setItem('records.user.records', JSON.stringify(records));
			localStorage.setItem('records.user.hasRecords', JSON.stringify(true));
		}
	});

}

//将当前可用的记录从缓存中取出并呈现到页面上。我们检查记录是否可用，如果可用则构建一个简单的HTML表格。
function showCurrentRecords(){
	if (!supports_html5_storage()) {
		return false;
	}
	var hasRecords = JSON.parse(localStorage.getItem("records.user.hasRecords"));
	if (!hasRecords) {
		$('#current-records > tbody').append('<tr><td colspan="4">No Records available</td></tr>');
	} else {
		var userRecords = JSON.parse(localStorage.getItem("records.user.records"));
		$.each(userRecords[0], function(index, row) {
			$('#current-records > tbody').append('<tr><td>' + (index + 1) 
												+ '</td><td>' + row.uname
												+ '</td><td>' + row.email + '</td></tr>');
		});
	}
}
//清除HTML 表格中的存在的记录。
function clearRecords(){
    $("#current-records > tbody > tr").remove();
}
//PHP脚本中检索数据，移除HTML表单中已存在的记录，重建查询到的记录。
function reloadRecords(){
    getRecordsFun();
    clearRecords();
    showCurrentRecords();
}

//goOnline 使得检测到在线状态时令应用在线。
function goOnline(){
    // persist the local records to the remote and clear the buffer
    var userRecords = JSON.parse(localStorage.getItem("records.user.local.records"));
  
    // process any records retrieved
    if (userRecords !=null && userRecords.length >= 1) {
        $.each(userRecords, function(index, row) {
            var dataString = 'firstname='+ row.firstname + '&lastname=' + row.lastname + '&emailaddress=' + row.emailaddress;
            $.ajax({
                type: "POST",
                url: "add-record.php",
                data: dataString,
                success: function() {
                    reloadRecords()
                }
            });
        });
        // clear out the offline cache after processing
        clearOfflineCache();
        // reload the records so that the user sees them
        reloadRecords();
    }
    // set the indicator flag to show that we're now online
    localStorage.setItem('records.offline.status', JSON.stringify('online'));
}
//
function goOffline(){
	localStorage.setItem('records.offline.status', JSON.stringify('offline'));
}
//
function isOffline(){
	var offlineStatus = JSON.parse(localStorage.getItem("records.offline.status"));
	if (offlineStatus) {
		return true;
	}
	return false;
}
function persistRemotely(){
    var uname = $("input[name='uname']").val();
    var email = $("input[name='email']").val();
    var dataString = 'uname='+ uname + '&email=' + email;
  
    // if online, submit to remote script
    $.ajax({
        type: "POST",
        url: "add-record.php",
        data: dataString,
        success: function() {
            reloadRecords();
        }
    });
    return false;
}

//persistToOfflineCache缓存浏览器离线时的表单数据
function persistToOfflineCache(){
   var uname = $("input[name='uname']").val();
    var email = $("input[name='email']").val();
  
    // retrieve the locally persisted records
    var records = JSON.parse(localStorage.getItem("records.user.local.records"));
  
    // parse the string to a json array
    var userRecord = {'uname':uname,'email':email};
  
    if (records != null) {
        // store the record in the local records
        records.push(userRecord);
    } else {
        var records = [];
        // store the record in the local records
        records.push(userRecord);
    }
  
    // write the information back to local storage
    localStorage.setItem('records.user.local.records', JSON.stringify(records));
}
$(document).ready(function() {
	if(navigator.onLine){
		goOnline();
	}else{
		goOffline();
	}
	// intercept the online event
	window.addEventListener("online", function() {
		console.log('联上网了...');
		goOnline();
	}, true);

	// intercept the offline event
	window.addEventListener("offline", function() {
		console.log('掉线了...');
		goOffline();
	}, true);

	// intercept the form submit event
	$('#btn').click(function() {
		if (isOffline()) {
			persistToOfflineCache();
		} else {
			persistRemotely();
		}
		$('#recordsform').reset();
		return false;
	});
	reloadRecords();
});



