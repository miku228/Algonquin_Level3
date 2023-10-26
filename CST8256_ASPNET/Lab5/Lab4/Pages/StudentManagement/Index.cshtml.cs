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
    public class IndexModel : PageModel
    {
        private readonly Lab5.DataAccess.StudentRecordContext _context;

        public IndexModel(Lab5.DataAccess.StudentRecordContext context)
        {
            _context = context;
        }

        public IList<Student> Student { get;set; } = default!;

        public IList<AcademicRecord> AcademicRecord { get; set; } = default!;

        public string? OrderBy { get; set; }

        public async Task<IActionResult> OnGetAsync(string orderby, string id, string delete)
        {
            if (_context.Students != null)
            {
                Student = await _context.Students.ToListAsync();
            }

            if (_context.AcademicRecords != null)
            {
                AcademicRecord = await _context.AcademicRecords
                .Include(a => a.CourseCodeNavigation)
                .Include(a => a.Student).ToListAsync();
            }
            // ********************
            // sorting the data
            // ********************
            // set Orderby Status to Session and Variable
            if (orderby != null)
            {
                // HttpContext.Session.SetString("orderby", orderby);
                OrderBy = orderby;
            }
            /*
            else if (HttpContext.Session.GetString("orderby") != null)
            {
                OrderBy = HttpContext.Session.GetString("orderby");
            }
            else
            {
                OrderBy = null;
            }
            */

            List<Student> students = await _context.Students.Include("AcademicRecords").ToListAsync();

            // sort Student data by Orderby Status
            if (OrderBy == "Name")
            {
                Student = students.OrderBy(s => s.Name).ToList();
            }
            else if (OrderBy == "NumberofCourses")
            {
                Student = students.OrderBy(s => s.NumberOfCourses).ToList();
            }
            else if (OrderBy == "AvgGrade")
            {
                Student = students.OrderBy(s => s.AvgGrade).ToList();
            }

            // ****************************************
            // deleting selected student the data
            // ****************************************
            if(delete != null)
            {
                Student studentToDelete = await _context.Students.FindAsync(delete);
                if(studentToDelete != null)
                {
                    // 1. Delete Academic Records
                    List<AcademicRecord> recordsToDelete = _context.AcademicRecords.Where(a => a.StudentId == delete).ToList();
                    foreach(AcademicRecord record in recordsToDelete)
                    {
                        _context.AcademicRecords.Remove(record);
                    }

                    // 2. Delete Student Records
                    _context.Students.Remove(studentToDelete);
                    // 3. Commit the change
                    await _context.SaveChangesAsync();
                }

                Student = await _context.Students.ToListAsync();

            }

            
            return Page();


        }


        /*
        public void OnGet(string orderby)
        {
            // set Orderby Status to Session and Variable
            if (orderby != null)
            {
                HttpContext.Session.SetString("orderby", orderby);
                OrderBy = orderby;
            }
            else if (HttpContext.Session.GetString("orderby") != null)
            {
                OrderBy = HttpContext.Session.GetString("orderby");
            }
            else
            {
                OrderBy = null;
            }

            // sort Student data by Orderby Status
            if (OrderBy == "Name")
            {
                Student.OrderBy(s => s.Name);
            }
            else if (OrderBy == "NumberofCourses")
            {
                
            }
            if (OrderBy == "AvgGrade")
            {
                
            }
        }
        */


    }
}
