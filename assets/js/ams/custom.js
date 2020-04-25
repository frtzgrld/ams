    
    function previousPage()
    {
        window.history.back();
    }

    function popup_window(url)
    {
        var wDisplay = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
            hDisplay = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight,
            wdisplay = wDisplay - (wDisplay * 0.1),
            hdisplay = hDisplay - (hDisplay * 0.1),
            ldisplay = (wDisplay - wdisplay)/2 ;
            
        window.open(url,'','height='+hdisplay+', width='+wdisplay+', left='+ldisplay+', top=10, , scrollbars=yes, menubar=no');
    }

    function scrolltop()
    {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }

    function add_commas(string) 
    {
        string += '';
        x = string.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function datatable_filter_overrides( datatable_id )
    {
        $('#'+datatable_id+'_wrapper>div.row:first-child>div:first-child').attr('style','float:right');
        $('#'+datatable_id+'_wrapper>div.row:first-child>div:last-child').attr('style','float:left');
        $('#'+datatable_id+'_filter>label').attr('style','float:left');
        $('#'+datatable_id+'_length select').select2();
        $('#'+datatable_id+'_filter>label>input').attr('style', 'width:300px;');
        $('#s2id_autogen1').attr('style', 'width: 75px;');
        $('.dataTables_length>label').attr('style','float:right');
    }