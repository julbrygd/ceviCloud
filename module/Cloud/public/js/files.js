$(function(){
    // Attach the dynatree widget to an existing <div id="tree"> element
    // and pass the tree options as an argument to the dynatree() function:
    $("#tree").dynatree({
        onActivate: function(node) {
            // A DynaTreeNode object is passed to the activation handler
            // Note: we also get this event, if persistence is on, and the page is reloaded.
            alert("You activated " + node.data.title);
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
            alert("popstate");
            ajaxFileLoad(location.pathname, lastFsoid.pop());
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
    alert("ajax load");
    $("#fileSection").load(url, {
        ajax: true
    }, function(){
        lastFsoid.push(actualFsoid);
        actualFsoid = id;
        reloadData();
    });
}
