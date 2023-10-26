// added by miku step7, Lab5
using Microsoft.EntityFrameworkCore;
using Lab5.DataAccess;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddRazorPages();

// added by miku step7, Lab5
string dbConnStr = builder.Configuration.GetConnectionString("StudentRecord");
builder.Services.AddDbContext<StudentRecordContext>(options => options.UseSqlServer(dbConnStr));

// add for using session by miku 20221107
builder.Services.AddSession(options =>
{
    options.IdleTimeout = TimeSpan.FromMinutes(10);
    options.Cookie.HttpOnly = true;
    options.Cookie.IsEssential = true;
});

var app = builder.Build();

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Error");
}
app.UseStaticFiles();

app.UseRouting();

app.UseAuthorization();

app.MapRazorPages();

app.Run();

// add for using session by miku 20221107
app.UseSession();

