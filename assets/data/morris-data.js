$(function() {

    Morris.Area({
        element: 'morris-area-chart-date',
        parseTime: false,
        data: [{
            date: 'Jan 1, 2019',
            Lost: 1
        }, {
            date: 'Jan 2, 2019',
            Lost: 6
        }, {
            date: 'Jan 3, 2019',
            Lost: 2
        }, {
            date: 'Jan 4, 2019',
            Lost: 1
        },{
            date: 'Jan 5, 2019',
            Lost: 6
        },{
            date: 'Jan 6, 2019',
            Lost: 5
        },{
            date: 'Jan 7, 2019',
            Lost: 6
        },{
            date: 'Jan 8, 2019',
            Lost: 5
        }],
        xkey: 'date',
        ykeys: ['Lost'],
        labels: ['Reported Lost Items'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true,
        lineColors: ['orange']
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });
    
});
