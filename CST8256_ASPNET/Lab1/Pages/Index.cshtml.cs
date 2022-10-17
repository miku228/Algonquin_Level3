using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace Lab1.Pages
{
    public class IndexModel : PageModel
    {
        public Boolean postFlag = false;

        [BindProperty]
        public string fNumber { get; set; } = "";
        [BindProperty]
        public string sNumber { get; set; } = "";
        [BindProperty]
        public string tNumber { get; set; } = "";

        public List<double> dNumbers { get; private set; } = new List<double>();

        // for results
        public double Max { get; private set; }
        public double Min { get; private set; }
        public double Total { get; private set; }
        public double Avg { get; private set; }


        private readonly ILogger<IndexModel> _logger;

        public IndexModel(ILogger<IndexModel> logger)
        {
            _logger = logger;
        }

        public void OnGet()
        {
          
        }

        public void OnPost()
        {
            postFlag = true;

            double dfNumber;
            double dsNumber;
            double dtNumber;

            double.TryParse(fNumber, out dfNumber);
            if(double.TryParse(fNumber, out dfNumber))
            {
                dNumbers.Add(dfNumber);
            }
            if (double.TryParse(sNumber, out dsNumber))
            {
                dNumbers.Add(dsNumber);
            }
            if (double.TryParse(tNumber, out dtNumber))
            {
                dNumbers.Add(dtNumber);
            }

            if(dNumbers.Count() > 0)
            {
                Max = dNumbers.Max();
                Min = dNumbers.Min();
                Total = dNumbers.Sum();
                Avg = dNumbers.Average();
            }


        }
    }
}