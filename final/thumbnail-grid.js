console.log("hello from thumbnail-grid");

function show_taglist_and_set_callbacks_once(tags_set)
{
    let taglist = $("#the-tag-list");
    let counter = 0;
    taglist.html("");
    tags_set.forEach(function(value)
    {
        taglist.append(
            `
                <button type="button" class="btn btn-outline-primary" id="tag-list-item-${counter.toString()}">${value}</button>
            `
        );
        counter = counter + 1;
    });

    for(let i = 0; i < tags_set.size; i++)
    {
        let taglist_item = $("#tag-list-item-" + i.toString());
        taglist_item.off().on("click", function(event)
        {
            event.stopPropagation();
            let tag = taglist_item.text();
            console.log(tag);
            let searchbox = $("#search-box");
            let current_str = searchbox.val();
            if(current_str)
            {
                searchbox.val(current_str + ", " + tag);
            }
            else
            {
                searchbox.val(tag);
            }
        });
    }
}

// displays tag list for associated image when thumbnail is clicked
function set_thumbnail_callbacks_and_populate_tag_list(tags_arr, tags_set)
{
    var thumbnail_grid = $("#thumbnail-grid");
    var thumbnails = $(".card-img-top");


    thumbnail_grid.off().on("click", function(event)
    {
        console.log("thumbnail grid whitespace clicked");
        let taglist = $("#the-tag-list");
        let counter = 0;
        taglist.html("");
        tags_set.forEach(function(value)
        {
            taglist.append(
                `
                    <button type="button" class="btn btn-outline-primary" id="tag-list-item-${counter.toString()}">${value}</button>
                `
            );
            counter = counter + 1;
        });

        for(let i = 0; i < tags_set.size; i++)
        {
            let taglist_item = $("#tag-list-item-" + i.toString());
            taglist_item.off().on("click", function(event)
            {
                event.stopPropagation();
                let tag = taglist_item.text();
                console.log(tag);
                let searchbox = $("#search-box");
                let current_str = searchbox.val();
                if(current_str)
                {
                    searchbox.val(current_str + ", " + tag);
                }
                else
                {
                    searchbox.val(tag);
                }
            });
        }
    });
    
    
    thumbnails.each(function(index)
    {
        let thumbnail_manage_button = $("#thumb-manage-button-id-" + index.toString());
        let thumbnail = $("#thumb-img-id-" + index.toString());
        let thumbnail_image_source_url = thumbnail.attr("src");

        thumbnail.off().on("click", function(event)
        {
            event.stopPropagation();    // otherwise the thumbnail_grid callback will happen
            console.log(index);
            let taglist = $("#the-tag-list");
            taglist.html("");
            for(let i = 0; i < tags_arr[index].length; i++)
            {
                taglist.append(
                    `
                        <button type="button" class="btn btn-outline-primary" id="tag-list-item-${i.toString()}">${tags_arr[index][i]}</button>
                    `
                );
            }

            for(let i = 0; i < tags_arr[index].length; i++)
            {
                let taglist_item = $("#tag-list-item-" + i.toString());
                taglist_item.off().on("click", function(event)
                {
                    event.stopPropagation();
                    let tag = taglist_item.text();
                    console.log(tag);
                    let searchbox = $("#search-box");
                    let current_str = searchbox.val();
                    if(current_str)
                    {
                        searchbox.val(current_str + ", " + tag);
                    }
                    else
                    {
                        searchbox.val(tag);
                    }
                });
            }

        });

        // set a callback for this button that will autopopulate modal field with image url when modal is launched (launched using same button)
        thumbnail_manage_button.off().on("click", function(event)
        {
            console.log(index);
            let manage_img_url_input_field = $("#manage-image-modal-url-input-field");
            manage_img_url_input_field.val(thumbnail_image_source_url);
        });
    });
}

// Add images to grid
function show_thumbnails(images_arr, tags_arr, tags_set)
{
    var grid = $("#thumbnail-grid");
    grid.html("");
    for (var i = 0; i < images_arr.length; i++)
    {
        var grid_id = i.toString();
        grid.append(`
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <img src="${images_arr[i]}" class="card-img-top" id="thumb-img-id-${grid_id}" alt="...">
                    <div class="card-body">
                        <button type="button" class="btn btn-outline-danger btn-sm manage-image-button" data-bs-toggle="modal" data-bs-target="#manage-image-modal" id="thumb-manage-button-id-${grid_id}">Delete</button>
                    </div>
                </div>
            </div>`);
    }
    set_thumbnail_callbacks_and_populate_tag_list(tags_arr, tags_set);
}