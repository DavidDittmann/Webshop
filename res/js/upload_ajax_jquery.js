
  function init() {
	  var dropbox = document.getElementById('dropbox');        
	  dropbox.addEventListener('dragenter', noopHandler, false);
	  dropbox.addEventListener('dragexit', noopHandler, false);
	  dropbox.addEventListener('dragover', noopHandler, false);
	  dropbox.addEventListener('drop', drop, false);
  }

  function noopHandler(evt) {
	evt.stopPropagation();
	evt.preventDefault();   
  }   
  
  function drop(evt) {
	evt.stopPropagation();
	evt.preventDefault();
	var files = evt.dataTransfer.files;
    var count = files.length; 
    for (i=0; i<count;i++) {   
		var formData = new FormData();
		formData.append("file", files[i]);

		$.ajax({
			type: "POST",
			data: formData,
			url: "upload_ajax.php",
			cache: false,
			contentType: false,
			processData: false,
			success: transferComplete
		});
    }
  }         

  function transferComplete(response, error) {
	console.log(response);
 	var result = document.getElementById('result'); 
	result.innerHTML = response;	
 }

