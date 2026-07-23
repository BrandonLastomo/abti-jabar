const fs = require('fs');
const path = require('path');

const directory = path.join(__dirname, 'resources', 'views', 'user');

function walkDir(dir, callback) {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        let isDirectory = fs.statSync(dirPath).isDirectory();
        isDirectory ? walkDir(dirPath, callback) : callback(path.join(dir, f));
    });
}

const replacements = [
    {
        regex: /bg-white overflow-hidden shadow-sm sm:rounded-lg/g,
        replace: 'bg-white/90 backdrop-blur-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:rounded-3xl transition-all'
    },
    {
        regex: /rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500/g,
        replace: 'rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors'
    },
    {
        regex: /rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500/g,
        replace: 'rounded-xl border-gray-200 bg-gray-50/50 shadow-sm focus:border-red-500 focus:ring-red-500 focus:bg-white transition-colors'
    },
    {
        regex: /text-sm font-medium text-gray-700/g,
        replace: 'text-sm font-bold text-gray-700'
    },
    {
        regex: /bg-gray-50 text-gray-500 uppercase text-xs font-bold tracking-wider/g,
        replace: 'bg-gray-50/50 text-gray-500 uppercase text-xs font-extrabold tracking-wider border-b border-gray-100'
    },
    {
        regex: /inline-flex items-center px-4 py-2 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm/g,
        replace: 'inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-0.5 transition-all'
    },
    {
        regex: /inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150/g,
        replace: 'inline-flex items-center px-5 py-2.5 bg-primary border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-0.5 transition-all focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2'
    },
    {
        regex: /inline-flex items-center px-5 py-2\.5 bg-red-700 text-white text-sm font-semibold rounded-lg hover:bg-red-800 transition shadow-sm/g,
        replace: 'inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-bold rounded-xl shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] hover:bg-red-700 hover:-translate-y-0.5 transition-all'
    },
    {
        regex: /px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-md hover:bg-blue-200 transition/g,
        replace: 'inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white transition-all shadow-sm'
    },
    {
        regex: /px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-md hover:bg-red-200 transition/g,
        replace: 'inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-lg bg-red-50 text-red-700 hover:bg-red-600 hover:text-white transition-all shadow-sm'
    },
    {
        regex: /px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition/g,
        replace: 'px-5 py-2.5 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 hover:-translate-y-0.5 shadow-sm transition-all'
    }
];

walkDir(directory, function(filePath) {
    if (!filePath.endsWith('.blade.php')) return;
    
    let content = fs.readFileSync(filePath, 'utf8');
    let original = content;

    replacements.forEach(r => {
        content = content.replace(r.regex, r.replace);
    });

    if (content !== original) {
        fs.writeFileSync(filePath, content, 'utf8');
        console.log('Updated:', filePath);
    }
});
console.log('Done.');
