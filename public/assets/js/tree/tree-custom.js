/**=====================
    Tree JS Start
==========================**/

let data = [
    {
      id: "0",
      text: "Applications",
      children: [
        {
          id: "0-0",
          text: "Ecommerce",
          children: [
            { id: "0-0-0", text: "Product" },
            { id: "0-0-1", text: "Cart" },
            { id: "0-0-2", text: "Invoice" },
          ],
        },
        {
          id: "0-1",
          text: "Users",
          children: [
            { id: "0-1-0", text: "Users-profile" },
            { id: "0-1-1", text: "Users-edit" },
            { id: "0-1-2", text: "Users-cards" },
          ],
        },
        {
          id: "0-2",
          text: "Chat",

        },
      ],
    },
    {
      id: "1",
      text: "Components",
      children: [
        {
          id: "1-0",
          text: "UI-Kits",
          children: [
            { id: "1-0-0", text: "Typography" },
            { id: "1-0-1", text: "Avatars" },
            { id: "1-0-2", text: "Grid" },
          ],
        },
        {
          id: "1-1",
          text: "Bonus-UI",
          children: [
            { id: "1-1-0", text: "Toasts" },
            { id: "1-1-1", text: "Rating" },
            { id: "1-1-2", text: "Pagination" },
          ],
        },
        {
          id: "1-2",
          text: "Charts",
          children: [
            { id: "1-2-0", text: "Apex-chart" },
            { id: "1-2-1", text: "Google-chart" },
            { id: "1-2-2", text: "Echarts" },
          ],
        },
      ],
    },
    {
      id: "2",
      text: "Miscellaneous",
      children: [
        {
          id: "2-0",
          text: "Gallery",
          children: [
            { id: "2-0-0", text: "Gallery-grid" },
            { id: "2-0-1", text: "Gallery-grid-desc" },
            { id: "2-0-2", text: "Masonry-gallery" },
          ],
        },
        {
          id: "2-1",
          text: "Blog",
          children: [
            { id: "2-1-0", text: "Blog-details" },
            { id: "2-1-1", text: "Blog-single" },
            { id: "2-1-2", text: "Add-post" },
          ],
        },
        {
          id: "2-2",
          text: "Editors",
          children: [
            { id: "2-2-0", text: "Summer-note" },
            { id: "2-2-1", text: "CK-editor" },
            { id: "2-2-2", text: "MDE-editor" },
          ],
        },
      ],
    },
  ];

    var treeData;
    $.ajax({
        type: "GET",
        url: "response.php",
        dataType: "json",
        success: function(response)
        {
        setmenus(response);
        // console.log(response);
        }
    });
    // function initTree(treeData) {
    //     $('#treeview_json').treeview({data: treeData});
    // }
    function setmenus(data){
        let tree=new Tree(".tree-container", {
            data: data,
            closeDepth: 3,
            collapseAll : false,
        });
    }
  let tree = new Tree(".tree-container", {
    // data: [{ id: "-1", text: "root", children: data2 }],
    data: data,
    closeDepth: 3,
    collapseAll : false,
    // loaded: function () {
    //   this.values = ["0-0-0", "0-1-1"];
    //   console.log(this.selectedNodes);
    //   console.log(this.values);
    // },
    onChange: function () {
      console.log(this.values);
    },
  });
