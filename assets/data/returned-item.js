$(function() {

    Morris.Area({
        element: 'returned-area-chart',
        parseTime: false,
        data: [{
            date: 'Jan 1, 2019',
            Found: 2
        }, {
            date: 'Jan 2, 2019',
            Found: 2
        }, {
            date: 'Jan 3, 2019',
            Found: 4
        }, {
            date: 'Jan 4, 2019',
            Found: 3
        }, {
            date: 'Jan 5, 2019',
            Found: 6
        }, {
            date: 'Jan 6, 2019',
            Found: 5
        }, {
            date: 'Jan 7, 2019',
            Found: 4
        }, {
            date: 'Jan 8, 2019',
            Found: 15
        }, {
            date: 'Jan 9, 2019',
            Found: 10
        }, {
            date: 'Jan 10, 2019',
            Found: 8
        }],
        xkey: 'date',
        ykeys: ['Found'],
        labels: ['Found'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true,
        lineColors: ['#00bc8c']
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
