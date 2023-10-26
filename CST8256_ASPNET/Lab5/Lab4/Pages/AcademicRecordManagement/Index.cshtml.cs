using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using Lab5.DataAccess;

namespace Lab5.Pages.AcademicRecordManagement
{
    public class IndexModel : PageModel
    {
        private readonly Lab5.DataAccess.StudentRecordContext _context;

        public IndexModel(Lab5.DataAccess.StudentRecordContext context)
        {
            _context = context;
        }

        public IList<AcademicRecord> AcademicRecord { get;set; } = default!;

        public async Task<IActionResult> OnGetAsync(string orderby, string delete, string courseId)
        {
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

                List<AcademicRecord> academicRecords = await _context.AcademicRecords.Include(a => a.CourseCodeNavigation).Include(a => a.Student).ToListAsync();

                // sort Student data by Orderby Status
                if (orderby == "Course")
                {
                    AcademicRecord = academicRecords.OrderByDescending(s => s.CourseCodeNavigation.Title).ToList();
                }
                else if (orderby == "Student")
                {
                    AcademicRecord = academicRecords.OrderByDescending(s => s.Student.Name).ToList();
                }
                if (orderby == "Grade")
                {
                    AcademicRecord = academicRecords.OrderByDescending(s => s.Grade).ToList();
                }

            }

            // ****************************************
            // deleting selected student the data
            // ****************************************
            if (delete != null)
            {
                AcademicRecord academicRecordToDelete = await _context.AcademicRecords.FindAsync(delete, courseId);
                if (academicRecordToDelete != null)
                {
                    // 1. Delete Academic Records
                    List<AcademicRecord> recordsToDelete = _context.AcademicRecords.Where(a => a.StudentId == delete).ToList();
                    foreach (AcademicRecord record in recordsToDelete)
                    {
                        if(record.CourseCode == courseId)
                        {
                            _context.AcademicRecords.Remove(record);
                        }
                        
                    }

                    
                    // 2. Commit the change
                    await _context.SaveChangesAsync();
                }

                //3. re-set new data
                AcademicRecord = await _context.AcademicRecords.ToListAsync();

            }

            
            return Page();

        }
    }
}
