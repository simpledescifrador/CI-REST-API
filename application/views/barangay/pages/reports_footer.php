<script type="text/javascript">

    $("#search-item").click(function() {
        var query = $('#search_keyword').val();
        $('#items').empty();$('#search-result').text('');
        $('#loading-display').text('Loading ...');

        setTimeout(function() {
            $.ajax({
            url: "<?php echo base_url(); ?>barangay/barangay_reports/get_items",
            type: 'GET',
            data: {
                q: query
            },
            dataType: "json",
            success: function(data) {
                $('#loading-display').text('');
                if (data.length > 0) {
                    $.each(data, function(index) {
                        data.reverse();
                        var itemId = data[index].item_id;
                        var typeClassName;
                        if (data[index].item_type == 'Found') {
                            typeClassName = 'success';
                        } else {
                            typeClassName = 'danger';
                        }
                        var html =  '<figure class="col-lg-3 col-md-6 col-xs-12" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">' +
                                        '<div class="card items-card">' +
                                        '<div class="card-body">' +
                                        '<img class="card-img-top img-fluid" src="<?php echo base_url(); ?>' + data[index].item_image_url + '" alt="Card image cap">' +
                                        '<div class="card-block">' +
                                        '<small class="tag tag-' + typeClassName + '">' +  data[index].item_type + ' </small>' +
                                        '<small class="text-muted">&nbsp;@;'+ data[index].item_location +'</small>' +
                                        '<h4 class="card-title mt-1">'+ data[index].item_title +'</h4>' +
                                        '<p><b>Posted By: </b>'+ data[index].account_name +'<br>' +
                                        '<small class="text-muted">'+ data[index].item_created_at +'</small></p>' +
                                        '<a href="<?php echo base_url() . "items/"; ?>'+ data[index].item_id +'" class="btn btn-outline-blue">View Details</a>' +
                                        '</div></div></div></figure>';
                        $('#items').append(html);
                    });
                } else {
                    $('#search-result').text("No Results Found");
                    // $('#bm').addClass('col-md-4');
                    // var animation = bodymovin.loadAnimation({
                    //     container: document.getElementById('bm'),
                    //     renderer: 'svg',
                    //     loop: true,
                    //     autoplay: true,
                    //     path: 'assets/animations/search-animation.json'
                    // });
                }


            }
        });
        }, 1000);
    });
</script>

</body>
</html>