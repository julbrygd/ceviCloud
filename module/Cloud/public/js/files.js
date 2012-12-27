$(function(){
    // Attach the dynatree widget to an existing <div id="tree"> element
    // and pass the tree options as an argument to the dynatree() function:
    $("#tree").dynatree({
        onActivate: function(node) {
            loadFilePath('/ui/file/path'+node.data.path, node.data.fsoid);
        },
        initAjax: {
            url: "/ui/file/folderStructure",
            //            url:"/test.json",
            data: {
                "fsoid": "0"
            }
        },
        onLazyRead: function(node){
            node.appendAjax({
                url: "/ui/file/folderStructure",
                data: {
                    "fsoid":node.data.fsoid
                }
            })
        },
        //        onPostInit: function(isReloading, isError , XMLHttpRequest, textStatus, errorThrown){
        //            alert(errorThrown);
        //        },
        persist: true/*,
           children: [ // Pass an array of nodes.
                {title: "Item 1"},
                {title: "Folder 2", isFolder: true,
                    children: [
                        {title: "Sub-item 2.1"},
                        {title: "Sub-item 2.2"}
                    ]
                },
                {title: "Item 3"}
            ]*/
    });
    
    $("a.fsFolderLink").bind("click", function(e){
        
       $(window).bind("popstate", function() {
            //ajaxFileLoad(location.pathname, lastFsoid.pop());
            location.reload();
        });
        var id = $(this).attr("id").substring("fsoLink_".length);
        var url = $(this).attr("href");
        loadFilePath(url, id);
        e.preventDefault();
        return false;
    });
});

function loadFilePath(url, id){
    history.pushState(null, null, url);
    ajaxFileLoad(url, id);
}

function reloadData(){
    var tree = $("#tree").dynatree("getTree");
    tree.reload();
    checkUpload();
}

function ajaxFileLoad(url, id){
    $("#fileSection").load(url, {
        ajax: true
    }, function(){
        lastFsoid.push(actualFsoid);
        actualFsoid = id;
        reloadData();
    });
}
