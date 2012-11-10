$(function(){
    // Attach the dynatree widget to an existing <div id="tree"> element
    // and pass the tree options as an argument to the dynatree() function:
    $("#tree").dynatree({
        onActivate: function(node) {
            // A DynaTreeNode object is passed to the activation handler
            // Note: we also get this event, if persistence is on, and the page is reloaded.
            alert("You activated " + node.data.title);
        },
        initAjax: {
            url: "/ui/file/folderStructure",
//            url:"/test.json",
            data: {
                "basePath": "/"
            }
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
});



