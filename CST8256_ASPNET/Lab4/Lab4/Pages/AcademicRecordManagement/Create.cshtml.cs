﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Lab4.DataAccess;

namespace Lab4.Pages.AcademicRecordManagement
{
    public class CreateModel : PageModel
    {
        private readonly Lab4.DataAccess.StudentRecordContext _context;

        public CreateModel(Lab4.DataAccess.StudentRecordContext context)
        {
            _context = context;
        }

        public IActionResult OnGet()
        {
        ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "Code");
        ViewData["StudentId"] = new SelectList(_context.Students, "Id", "Id");
            return Page();
        }

        [BindProperty]
        public AcademicRecord AcademicRecord { get; set; }
        

        // To protect from overposting attacks, see https://aka.ms/RazorPagesCRUD
        public async Task<IActionResult> OnPostAsync()
        {
          if (!ModelState.IsValid)
            {
                return Page();
            }

            _context.AcademicRecords.Add(AcademicRecord);
            await _context.SaveChangesAsync();

            return RedirectToPage("./Index");
        }
    }
}