function form_valid_submit(formulario, end){
	$(formulario).on('submit', function(event) {
		event.preventDefault();
		if ($(formulario).validationEngine('validate') ) {
			var formData = new FormData($(formulario)[0]);
			$.ajax({            
				type: "POST",
				url: 'includes/ajax.php',
				data: formData,
				cache: false,
				/*
				xhr: function() {  // custom xhr
	                myXhr = $.ajaxSettings.xhr();
	                if(myXhr.upload){ // check if upload property exists
	                	$('#loader').show();
	                    myXhr.upload.addEventListener('progress',updateProgress, false); // for handling the progress of the upload
	                }
	                return myXhr;
	            },*/
	            contentType: false,
	            processData: false,
	            async: true,
				success: function(response){
					end(JSON.parse(response), formulario);
				}
				
			});	
		}else{

		}
		return false;
	});
}
function updateProgress(evt) {
    if (evt.lengthComputable) {
            var percentComplete = Math.round((evt.loaded / evt.total)*100);
            console.log(percentComplete);
            document.getElementById("bar_color").style.width = percentComplete + "%";
        	document.getElementById("status").innerHTML = percentComplete + "%";
            if(percentComplete == 100){
            	$('#loader').hide();
            }
    } else {
            // Unable to compute progress information since the total size is unknown
            console.log('No se puede completar');
    }
}


$(function() {
	function end1(e,form){
	    if(e != "")
	    {
	        var arreglo =  e.salida_arreglo;
	        var texto =  e.salida_texto;
	        if(arreglo == 1)
	        {
	            swal("Buen Trabajo!", "Te haz registrado correctamente", "success");
	            $(form)[0].reset();     
	        }else{
	        	swal("UPS!", "Algo va mal, intenta nuevamente! "+texto, "error"); 
	        }
	    }else{
	        
	    }
	}

	//init!!
	form_valid_submit("#form1", end1);
}); 

document.addEventListener('touchmove', function(event) {
    event = event.originalEvent || event;
    if(event.scale > 1) {
      event.preventDefault();
    }
 }, false);

document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
});










