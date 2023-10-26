using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using Lab5.DataAccess;

namespace Lab5.Pages.StudentManagement
{
    public class DetailsModel : PageModel
    {
        private readonly Lab5.DataAccess.StudentRecordContext _context;

        public DetailsModel(Lab5.DataAccess.StudentRecordContext context)
        {
            _context = context;
        }

      public Student Student { get; set; }
      public List<Course> Courses { get; set; } 

        public async Task<IActionResult> OnGetAsync(string id)
        {
            if (id == null || _context.Students == null)
            {
                return NotFound();
            }

            var student = await _context.Students.Include("AcademicRecords").FirstOrDefaultAsync(m => m.Id == id);
            var courses = await _context.Courses.ToListAsync();

            if (student == null)
            {
                return NotFound();
            }
            else 
            {
                Student = student;
                Courses = courses;
            }
            return Page();
        }
    }
}
