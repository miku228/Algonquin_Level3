using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using Lab5.DataAccess;

namespace Lab5.Pages.AcademicRecordManagement
{
    public class EditModel : PageModel
    {
        private readonly Lab5.DataAccess.StudentRecordContext _context;

        public EditModel(Lab5.DataAccess.StudentRecordContext context)
        {
            _context = context;
        }

        [BindProperty]
        public AcademicRecord AcademicRecord { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(string studentId, string courseId)
        {
            if (studentId == null || courseId == null)
            {
                return NotFound();
            }

            var academicrecord =  await _context.AcademicRecords.Include(r => r.Student).Include(r => r.CourseCodeNavigation).FirstOrDefaultAsync(m => m.StudentId == studentId);
            if (academicrecord == null)
            {
                return NotFound();
            }


            AcademicRecord = academicrecord;
           ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "Code");
           ViewData["StudentId"] = new SelectList(_context.Students, "Id", "Id");
            
            return Page();
        }

        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see https://aka.ms/RazorPagesCRUD.
        public async Task<IActionResult> OnPostAsync()
        {
            /*
            if (!ModelState.IsValid)
            {
                return Page();
            }
            */
            

            var updateAcademicRecord = await _context.AcademicRecords.Include(r => r.Student).Include(r => r.CourseCodeNavigation).FirstOrDefaultAsync(m => m.StudentId == AcademicRecord.StudentId);
            updateAcademicRecord.Grade = AcademicRecord.Grade;

            // _context.Update(updateAcademicRecord);

            _context.Attach(updateAcademicRecord).State = EntityState.Modified;

            try
            {
                await _context.SaveChangesAsync();
            }
            catch (DbUpdateConcurrencyException)
            {
                if (!AcademicRecordExists(AcademicRecord.StudentId))
                {
                    return NotFound();
                }
                else
                {
                    throw;
                }
            }

            return RedirectToPage("./Index");
        }

        private bool AcademicRecordExists(string id)
        {
          return _context.AcademicRecords.Any(e => e.StudentId == id);
        }
    }
}
