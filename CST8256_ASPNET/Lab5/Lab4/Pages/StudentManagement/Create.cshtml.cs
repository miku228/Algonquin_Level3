using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Lab5.DataAccess;
using Microsoft.EntityFrameworkCore;

namespace Lab5.Pages.StudentManagement
{
    public class CreateModel : PageModel
    {
        private readonly Lab5.DataAccess.StudentRecordContext _context;

        public CreateModel(Lab5.DataAccess.StudentRecordContext context)
        {
            _context = context;
        }

        public IActionResult OnGet()
        {
            return Page();
        }

        [BindProperty]
        public Student Student { get; set; }
        
        public string? errorMessage { get; set; }
        

        // To protect from overposting attacks, see https://aka.ms/RazorPagesCRUD
        public async Task<IActionResult> OnPostAsync()
        {
          if (!ModelState.IsValid)
            {
                return Page();
            }

           List<Student> students = await _context.Students.ToListAsync();
           
            if(students.FirstOrDefault(s => s.Id == Student.Id) != null)
            {
                errorMessage = "Student Id :" + Student.Id + ", already exists";
                return Page();
                
            }else
            {
                _context.Students.Add(Student);
                await _context.SaveChangesAsync();
                return RedirectToPage("./Index");
            }
           
            /*
           try
            {
                _context.Students.Add(Student);
                await _context.SaveChangesAsync();
                return RedirectToPage("./Index");
            }
            catch(Exception e)
            {
                errorMessage = "Student Id :" + Student.Id + ", already exists";
                throw errorMessage;
            }
           */
 
        }
    }
}
