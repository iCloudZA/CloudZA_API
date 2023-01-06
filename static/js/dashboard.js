/*!
 * 统计图表
 * codebase - v5.2.0
 * @author pixelcave - https://pixelcave.com
 * Copyright (c) 2022
 */
console.log('CloudZA');
Codebase.onLoad(() =>
  class {
    static initDashboardChartJS() {
      (Chart.defaults.color = "#818d96"),
        (Chart.defaults.scale.grid.color = "transparent"),
        (Chart.defaults.scale.grid.zeroLineColor = "transparent"),
        (Chart.defaults.scale.display = !1),
        (Chart.defaults.scale.beginAtZero = !0),
        (Chart.defaults.elements.line.borderWidth = 2),
        (Chart.defaults.elements.point.radius = 5),
        (Chart.defaults.elements.point.hoverRadius = 7),
        (Chart.defaults.plugins.tooltip.radius = 3),
        (Chart.defaults.plugins.legend.display = !1);
      let e,
        a,
        t = document.getElementById("js-chartjs-dashboard-lines"),
        r = document.getElementById("js-chartjs-dashboard-lines2");
      null !== t &&
        (e = new Chart(t, {
          type: "line",
          data: {
            labels: ["2022年10月1日", "2022年10月2日", "2022年10月3日", "2022年10月4日", "2022年10月5日", "2022年10月6日", "2022年10月7日"],
            datasets: [
              {
                label: "结算统计表",
                fill: !0,
                backgroundColor: "rgba(2, 132, 199, .45)",
                borderColor: "rgba(2, 132, 199, 1)",
                pointBackgroundColor: "rgba(2, 132, 199, 1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(2, 132, 199, 1)",
                data: [12, 35, 73.5, 43.5, 42.5, 75, 89]
              }
            ]
          },
          options: {
            tension: 0.4,
            scales: { y: { suggestedMin: 0, suggestedMax: 50 } },
            interaction: { intersect: !1 },
            plugins: {
              tooltip: {
                callbacks: {
                  label: function (e) {
                    return " " + e.parsed.y + " 元";
                  }
                }
              }
            }
          }
        }));
    }
    static init() {
      this.initDashboardChartJS();
    }
  }.init()
);
