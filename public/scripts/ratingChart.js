var data = [
    {
        x: ['2013-10-04', '2013-11-04', '2013-12-04'],
        y: [1000, 1200, 1600],
        type: 'scatter'
    }
];

var layout = {
    title: 'Rating',
    height: '300',
    plot_bgcolor: 'rgba(0, 0,0,0)',

    showlegend: false,
    xaxis: {
        showgrid: false
    },
    yaxis: {
        showgrid: false
    },
    paper_bgcolor: 'rgba(0, 0, 0, 0)'
};

const config =
    {
        staticPlot: false,
        displayModeBar:false,
    }

Plotly.newPlot('ratingChart', data, layout, config);
