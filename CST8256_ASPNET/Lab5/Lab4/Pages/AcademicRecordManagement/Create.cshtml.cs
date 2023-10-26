using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Lab5.DataAccess;
using Microsoft.EntityFrameworkCore;

namespace Lab5.Pages.AcademicRecordManagement
{
    public class CreateModel : PageModel
    {
        private readonly Lab5.DataAccess.StudentRecordContext _context;

        public CreateModel(Lab5.DataAccess.StudentRecordContext context)
        {
            _context = context;
        }


        [BindProperty]
        public AcademicRecord AcademicRecord { get; set; }
        public List<AcademicRecord> academicRecords { get; set; }

        public string? errorMessage { get; set; }


        public IActionResult OnGet()
        {
            
            //
            // academicRecords = _context.AcademicRecords.Include(r => r.Student).Include(r => r.CourseCodeNavigation).ToList();
            /*
            if(academicRecords != null)
            {
                AcademicRecord = academicRecords;
            }
            */
            ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "DisplayText");
            ViewData["StudentId"] = new SelectList(_context.Students, "Id", "DisplayText");
            return Page();
        }

        

        // To protect from overposting attacks, see https://aka.ms/RazorPagesCRUD
        public async Task<IActionResult> OnPostAsync()
        {
            /*
              if (!ModelState.IsValid)
                {
                    return Page();
                }
            */

            academicRecords = _context.AcademicRecords.Include(r => r.Student).Include(r => r.CourseCodeNavigation).ToList();
            ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "DisplayText");
            ViewData["StudentId"] = new SelectList(_context.Students, "Id", "DisplayText");

            foreach (var academicRecord in academicRecords)
            {
                if(academicRecord.StudentId == AcademicRecord.StudentId && academicRecord.CourseCode == AcademicRecord.CourseCode)
                {
                    errorMessage = "The specific academic record already exist!";
                    return Page();
                }
            }
            

            _context.AcademicRecords.Add(AcademicRecord);
            await _context.SaveChangesAsync();

            return RedirectToPage("./Index");
        }
    }
}
