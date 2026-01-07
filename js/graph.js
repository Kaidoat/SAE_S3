// Graphique par âge
new Chart(document.getElementById('ageChart'), {
    type: 'pie',
    data: {
        labels: ages.map(a => a.tranche_age),
        datasets: [{
            data: ages.map(a => a.nb),
            backgroundColor: ['#ff6384','#36a2eb','#ffcd56','#4bc0c0','#9966ff']
        }]
    },
    options: { responsive:true, plugins:{title:{display:true,text:'Répartition par âge'}} }
});

// Graphique par origine
new Chart(document.getElementById('origineChart'), {
    type: 'doughnut',
    data: {
        labels: origines.map(o => o.origine),
        datasets: [{
            data: origines.map(o => o.nb),
            backgroundColor: ['#36a2eb','#ff6384','#ffcd56','#4bc0c0','#9966ff','#ff9f40']
        }]
    },
    options: { responsive:true, plugins:{title:{display:true,text:'Répartition par origine'}} }
});

// Graphique par profession/statut
new Chart(document.getElementById('professionChart'), {
    type: 'bar',
    data: {
        labels: professions.map(p => p.statut),
        datasets: [{
            label: 'Nombre',
            data: professions.map(p => p.nb),
            backgroundColor: '#36a2eb'
        }]
    },
    options: { responsive:true, plugins:{title:{display:true,text:'Répartition par profession'}}, scales:{y:{beginAtZero:true}} }
});
