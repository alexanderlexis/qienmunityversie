function contactPost(){                 //voor contactmail pagina
    var subject = $(".subject").val();
    var text = $(".text").val();
    
    objectify(subject, text);
}

function objectify(subject, text){      //voor contactmail pagina
    var mail = {};
    mail.subject = subject;
    mail.text = text;
    
    var mailjson = JSON.stringify(mail);
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        document.getElementById('mailSucces').innerHTML = this.responseText;
    };
    xhttp.open("POST","/contactMail", true);
    xhttp.send(mailjson);
}
    
function zoeken(){                      //voor nieuwspagina
    var data = {
    term:$(".form-control").val(),
    _token:$(".form-control").data('token')
    };
    
    var jsondata = JSON.stringify(data);
    query(jsondata);
}
    
function query(jsondata){               //voor nieuwspagina
    var url = $(".form-control").attr("data-link");
    
    $.ajax({
        url:"/zoek",
        data: jsondata,
        datatype:"json",
        type:"POST",
        
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        
        success:function(data){ 
            if (data.length !== 0){
                paginaData(data);
            }else{
                $("#tabelZoekResultaat").html(" ");
                $("#tabelZoek").show();
            }
        },error:function(){ 
            console.log("HTTP error");
        }
    }); 
}

function paginaData(data){                  //voor nieuwspagina
    var i;
    $("#tabelZoek").hide();
    $("#tabelZoekResultaat").html(" ");
    for(i = 0; i < data.length; i++){
        
        $( "#tabelZoekResultaat" ).append(  
            '<div class="well">'+
            '<div class="card-body">'+
            '<h3 class="card-title" id="qien--colour">'+data[i]['title']+'</h3>'+
            '<p class="card-text">'+data[i]['content']+'</p>'+
            '<p class="card-text"><small class="text-muted">Gepost op:'+data[i]['created_at']+'</small></p>'+
            '<a href="/nieuwsposts/'+data[i]['id']+' class="btn btn-default">Lees Verder</a>'+
            '</div>');

    }
}
///////////////////////////////////////////////////////////////
function zoekComm(){                      //voor communitypagina
    
    var dropDownKeuze = $("#dropDownKeuze").val();
    var invoerData = $("#zoekComm").val();
    if(dropDownKeuze == "gebruiker"){
       zoekCommDiff(1, invoerData);
    }else{
       zoekCommDiff(0, invoerData); 
   }
}
function zoekCommDiff(Diff, invoerdata){
 var dataComm = {
     diff:Diff,
     term:invoerdata,
     _token:$(".form-control").data('token')
     };
    
     var jsondataComm = JSON.stringify(dataComm);
     queryComm(jsondataComm);
}

   
function queryComm(jsondataComm){               //voor communitypagina
    var url = $(".form-control").attr("data-link");
    
    $.ajax({
        url:"/zoekComm",
        data: jsondataComm,
        datatype:"json",
        type:"POST",
        
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        
        success:function(data){
            $("#tabelZoekResultaatCommNull").hide();
            var check = $("#zoekComm").val();
             
            if (data.length !== 0){
                paginaDataComm(data);                
            }else if(check.length !== 0){
                $("#tabelZoekResultaatComm").html(" ");
                $("#tabelZoekComm").hide();
                $("#tabelZoekResultaatCommNull").show();
                $("#tabelZoekResultaatCommNull").html("Geen zoekresultaten");
            }else{
                $("#tabelZoekResultaatComm").html(" ");
                $("#tabelZoekComm").show();
            }
        },error:function(){ 
            console.log("HTTP error");
        }
    }); 
}

function paginaDataComm(data){                  //voor nieuwspagina
    var i;
    $("#tabelZoekComm").hide();
    $("#tabelZoekResultaatComm").html(" ");
    for(i = 0; i < data.length; i++){
        
        $( "#tabelZoekResultaatComm" ).append(  
            '<div class="well">'+
            '<div class="card-body">'+
            '<h3 class="card-title" id="qien--colour">'+data[i]['title']+'</h3>'+
            '<p class="card-text">'+data[i]['content'].substr(0, 100)+'</p>'+
            '<p class="card-text"><small class="text-muted">Gepost op:'+data[i]['created_at']+'</small></p>'+
            '<a href="/communitypost/'+data[i]['id']+' class="btn btn-default">Lees Verder</a>'+
            '</div>');

    }
}

