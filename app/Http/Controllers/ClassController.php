<?php
// app/Http/Controllers/ClassController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Hiển thị danh sách lớp học
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search', '');
        
        $classes = Classes::when($search, function($query, $search) {
            return $query->where('class_code', 'like', "%{$search}%")
                        ->orWhere('class_name', 'like', "%{$search}%")
                        ->orWhere('teacher_name', 'like', "%{$search}%");
        })->paginate($perPage);
        
        return view('classes.index', compact('classes', 'perPage', 'search'));
    }

    // Hiển thị form thêm lớp học
    public function create()
    {
        return view('classes.create');
    }

    // Xử lý thêm lớp học
    public function store(Request $request)
    {
        $request->validate([
            'class_code' => 'required|unique:classes|max:50',
            'class_name' => 'required|max:255',
            'teacher_name' => 'required|max:255',
            'max_students' => 'required|integer|min:1|max:200',
            'room' => 'nullable|max:50',
            'description' => 'nullable'
        ]);

        Classes::create($request->all());

        return redirect()->route('classes.index')
                        ->with('success', 'Thêm lớp học thành công!');
    }

    // Hiển thị form sửa lớp học
    public function edit($id)
    {
        $class = Classes::findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    // Xử lý cập nhật lớp học
    public function update(Request $request, $id)
    {
        $class = Classes::findOrFail($id);
        
        $request->validate([
            'class_code' => 'required|max:50|unique:classes,class_code,' . $id,
            'class_name' => 'required|max:255',
            'teacher_name' => 'required|max:255',
            'max_students' => 'required|integer|min:1|max:200',
            'room' => 'nullable|max:50',
            'description' => 'nullable'
        ]);

        $class->update($request->all());

        return redirect()->route('classes.index')
                        ->with('success', 'Cập nhật lớp học thành công!');
    }

    // Xóa lớp học
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->route('classes.index')
                        ->with('success', 'Xóa lớp học thành công!');
    }
}