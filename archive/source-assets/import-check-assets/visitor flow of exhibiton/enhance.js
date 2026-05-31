const fs = require('fs');
const path = require('path');

const dir = __dirname;
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');

    // Make sure the main content area has the gradient
    // We look for 'class="flex-1 overflow-y-auto' which is the universal signature of the main content area in this app
    content = content.replace(/class="flex-1 overflow-y-auto([^"]*)"/g, (match, p1) => {
        // Remove existing backgrounds
        let newClasses = p1.replace(/bg-gray-50\/30/g, '').replace(/bg-white/g, '').replace(/bg-gray-50/g, '').trim();
        // Add our gradient
        if (!newClasses.includes('bg-gradient-to-br')) {
            newClasses += ' bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]';
        }
        return `class="flex-1 overflow-y-auto ${newClasses}"`;
    });
    
    // Some pages have cards without standard shadow-sm or have custom classes
    // Add hover effects to typical cards (rounded-xl, rounded-2xl, rounded-lg, rounded-[24px]) that have bg-white
    content = content.replace(/class="([^"]*?bg-white[^"]*?border[^"]*?)"/g, (match, p1) => {
        if (p1.match(/rounded-xl|rounded-2xl|rounded-\[24px\]|rounded-lg/)) {
            // Exclude small buttons or inputs
            if (!p1.match(/w-full|text-\[|px-2|py-1|px-6 py-3.5/)) {
                if (!p1.includes('hover:-translate-y-1')) {
                    let updated = p1.trim() + ' hover:-translate-y-1 hover:shadow-md transition-all duration-300';
                    return `class="${updated}"`;
                }
            }
        }
        return match;
    });
    
    // Also add to any remaining cards that just have 'bg-white rounded-2xl' or similar
    content = content.replace(/class="([^"]*?bg-white[^"]*?rounded-2xl[^"]*?)"/g, (match, p1) => {
        if (!p1.match(/w-full|text-\[|px-2/)) {
            if (!p1.includes('hover:-translate-y-1')) {
                let updated = p1.trim() + ' hover:-translate-y-1 hover:shadow-md transition-all duration-300';
                return `class="${updated}"`;
            }
        }
        return match;
    });

    fs.writeFileSync(path.join(dir, file), content, 'utf8');
});

console.log('Universal UI enhancements applied to ' + files.length + ' files.');
