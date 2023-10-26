﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.Rendering;
using Microsoft.EntityFrameworkCore;
using Lab8.Models.DataAccess;

namespace Lab8.Controllers
{
    public class AcademicRecordsController : Controller
    {
        private readonly StudentRecordContext _context;

        public AcademicRecordsController(StudentRecordContext context)
        {
            _context = context;
        }

        // GET: AcademicRecords
        public async Task<IActionResult> Index()
        {
            var studentRecordContext = _context.AcademicRecords.Include(a => a.CourseCodeNavigation).Include(a => a.Student);
            return View(await studentRecordContext.ToListAsync());
        }
        
        // GET: AcademicRecords/Create
        public IActionResult Create()
        {
            ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "Code");
            ViewData["StudentId"] = new SelectList(_context.Students, "Id", "Id");
            return View();
        }

        // POST: AcademicRecords/Create
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Create([Bind("CourseCode,StudentId,Grade")] AcademicRecord academicRecord)
        {
            if (ModelState.IsValid)
            {
                
                var existingRecord = await _context.AcademicRecords.Include(r => r.Student).Include(a => a.CourseCodeNavigation).SingleOrDefaultAsync(r => r.StudentId == academicRecord.StudentId && r.CourseCode == academicRecord.CourseCode);
                if(existingRecord != null)
                {
                    ViewBag.ErrorMessage = "The specific academic record already exist!";
                    ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "Code", academicRecord.CourseCode);
                    ViewData["StudentId"] = new SelectList(_context.Students, "Id", "Id", academicRecord.StudentId);
                    return View(academicRecord);
                }
                else
                {
                    _context.Add(academicRecord);
                    await _context.SaveChangesAsync();
                    return RedirectToAction(nameof(Index));
                }
                
                
                
            }
            ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "Code", academicRecord.CourseCode);
            ViewData["StudentId"] = new SelectList(_context.Students, "Id", "Id", academicRecord.StudentId);
            return View(academicRecord);
        }

        // GET: AcademicRecords/Edit/5
        public async Task<IActionResult> Edit(string studentId, string courseCode)
        {
            if (studentId == null || _context.AcademicRecords == null || courseCode == null)
            {
                return NotFound();
            }

            var academicRecord = await _context.AcademicRecords.Include(r => r.Student).Include(r => r.CourseCodeNavigation).FirstOrDefaultAsync(m => m.StudentId == studentId && m.CourseCode == courseCode);
            //var academicRecord = await _context.AcademicRecords.Include(r => r.Student).Include(r => r.CourseCodeNavigation).FirstOrDefaultAsync(m => m.StudentId == studentId);
            //.FindAsync(studentId, courseCode);
            if (academicRecord == null)
            {
                return NotFound();
            }
            ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "Code", academicRecord.CourseCode);
            ViewData["StudentId"] = new SelectList(_context.Students, "Id", "Id", academicRecord.StudentId);
            return View(academicRecord);
        }

        // POST: AcademicRecords/Edit/5
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Edit(string studentId, [Bind("CourseCode,StudentId,Grade")] AcademicRecord academicRecord)
        {
            if (studentId != academicRecord.StudentId)
            {
                return NotFound();
            }

            if (ModelState.IsValid)
            {
                try
                {
                    _context.Update(academicRecord);
                    await _context.SaveChangesAsync();
                }
                catch (DbUpdateConcurrencyException)
                {
                    if (!AcademicRecordExists(academicRecord.StudentId))
                    {
                        return NotFound();
                    }
                    else
                    {
                        throw;
                    }
                }
                return RedirectToAction(nameof(Index));
            }
            ViewData["CourseCode"] = new SelectList(_context.Courses, "Code", "Code", academicRecord.CourseCode);
            ViewData["StudentId"] = new SelectList(_context.Students, "Id", "Id", academicRecord.StudentId);
            return View(academicRecord);
        }


        /****************************
         * 
         * Edit All Page 
         *      added by miku 2022.11.22
         * 
         ****************************/
        // GET: AcademicRecords/EditAll/5
        public async Task<IActionResult> EditAll()
        {
            var studentRecordContext = _context.AcademicRecords.Include(a => a.CourseCodeNavigation).Include(a => a.Student);
            return View(await studentRecordContext.ToListAsync());

        }

        // POST: AcademicRecords/EditAll/5
        // To protect from overposting attacks, enable the specific properties you want to bind to.
        // For more details, see http://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> EditAll(IFormCollection academicRecords)
        {
            /*
            if (studentId != academicRecord.StudentId)
            {
                return NotFound();
            }
            */
            if (ModelState.IsValid)
            {
                // try{
                    for(var i = 0; i < academicRecords["item.CourseCode"].Count; i++)
                    {
                        var courseCode = academicRecords["item.CourseCode"][i];
                        var studentId = academicRecords["item.StudentId"][i];
                        var grade = Int32.Parse(academicRecords["item.Grade"][i]);

                        try
                        {
                            var academicRecord = _context.AcademicRecords.Include(r => r.Student).Include(a => a.CourseCodeNavigation)
                            .FirstOrDefault(r => r.StudentId == studentId && r.CourseCode == courseCode);
                            academicRecord.Grade = grade;

                            _context.Update(academicRecord);
                            await _context.SaveChangesAsync();
                        }
                        catch (DbUpdateConcurrencyException)
                        {

                            if (!AcademicRecordExists(studentId))
                            {
                                return NotFound();
                            }
                            else
                            {
                                throw;
                            }

                        }
                        
                        
                    }
                    /*
                    _context.Update(academicRecords);
                    await _context.SaveChangesAsync();
                   
                }
                
                catch (DbUpdateConcurrencyException)
                {
                    
                    if (!AcademicRecordExists(academicRecords.StudentId))
                    {
                        return NotFound();
                    }
                    else
                    {
                        throw;
                    }
                    
                }
                */
                return RedirectToAction(nameof(Index));
            }
           
            return View(academicRecords);
            
        }
        
        private bool AcademicRecordExists(string id)
        {
          return _context.AcademicRecords.Any(e => e.StudentId == id);
        }
    }
}
