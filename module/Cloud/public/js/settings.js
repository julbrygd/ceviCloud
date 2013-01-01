

$(function(){
    var dav=new DavClient();
    $("#davSaveButton").bind("click", function(){
        $.post(davSaveUrl, dav.getData(), function(data){
            if(typeof(data.status)!="undefined"&&data.status == "ok"){
                alert("Daten wurden gespeicher");
                dav = new DavClient();
            } else {
                alert("Ein Fehler ist aufgetreten");
            }
        });
        return false;
    });
    $(".clientCheckbox").bind("change", function(){
        var elem = $(this);
        dav.set(elem.val(), elem.attr("checked"));
    });
});

function DavClient() {
    this.data = {};
}

DavClient.prototype.set = function(id, value){
    if(typeof(value)=="undefined") {
        value = false;
    } else {
        value = true;
    }
    if(typeof(this.data[id])=="undefined"){
        this.data[id] = value;
    } else {
        delete this.data[id];
    }
}

DavClient.prototype.getData = function() {
    return this.data;
}