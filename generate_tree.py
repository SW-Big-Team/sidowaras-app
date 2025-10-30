import os

ignore_dirs = {
    # Laravel cache & runtime
    'bootstrap/cache',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/testing',
    'storage/framework/views',  # hasil compile Blade — jangan tampilkan!
    'storage/logs',
    
    # Aset statis hasil download/template (opsional, tapi disarankan diabaikan)
    'public/assets',
    
    # Dependensi & build (jika muncul)
    'vendor',
    'node_modules',
    'public/build',
    
    # File sistem / IDE (jika ada)
    '.git',
    '.idea',
    '.vscode',
    '__pycache__',
}


def print_directory_tree(startpath, output_file="struktur.txt", ignore_dirs=ignore_dirs):
    
    with open(output_file, "w", encoding="utf-8") as f:
        for root, dirs, files in os.walk(startpath):
            # Filter direktori yang diabaikan
            dirs[:] = [d for d in dirs if d not in ignore_dirs]
            
            level = root.replace(startpath, '').count(os.sep)
            indent = '│   ' * (level)
            f.write(f'{indent}├── {os.path.basename(root)}/\n')
            subindent = '│   ' * (level + 1)
            for file in files:
                f.write(f'{subindent}├── {file}\n')


folder_proyek = r"C:\Users\Administrator\Desktop\PTI\sidowaras-app"
print_directory_tree(folder_proyek, "struktur.txt")