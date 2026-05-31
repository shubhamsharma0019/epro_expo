import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const dir = __dirname;
const files = fs.readdirSync(dir).filter(f => f.endsWith('.html'));

files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');

    // Make sure the main content area has the gradient
    content = content.replace(/class="flex-1 overflow-y-auto([^"]*)"/g, (match, p1) => {
        let newClasses = p1.replace(/bg-gray-50\/30/g, '').replace(/bg-white/g, '').replace(/bg-gray-50/g, '').trim();
        if (!newClasses.includes('bg-gradient-to-br')) {
            newClasses += ' bg-gradient-to-br from-[#FAFAFA] to-[#EDE9FE]';
        }
        return `class="flex-1 overflow-y-auto ${newClasses}"`;
    });
    
    // Add hover effects to typical cards
    content = content.replace(/class="([^"]*?bg-white[^"]*?border[^"]*?)"/g, (match, p1) => {
        if (p1.match(/rounded-xl|rounded-2xl|rounded-\[24px\]|rounded-lg/)) {
            if (!p1.match(/w-full|text-\[|px-2|py-1|px-6 py-3.5/)) {
                if (!p1.includes('hover:-translate-y-1')) {
                    let updated = p1.trim() + ' hover:-translate-y-1 hover:shadow-md transition-all duration-300';
                    return `class="${updated}"`;
                }
            }
        }
        return match;
    });
    
    content = content.replace(/class="([^"]*?bg-white[^"]*?rounded-2xl[^"]*?)"/g, (match, p1) => {
        if (!p1.match(/w-full|text-\[|px-2/)) {
            if (!p1.includes('hover:-translate-y-1')) {
                let updated = p1.trim() + ' hover:-translate-y-1 hover:shadow-md transition-all duration-300';
                return `class="${updated}"`;
            }
        }
        return match;
    });

    // --- RESPONSIVE WEB APP REPLACEMENTS ---
    
    // Smart replacements to make all flex containers responsive (stack on mobile, side-by-side on desktop)
    content = content.replace(/class="([^"]*?\bflex\b[^"]*?\bgap-8\b[^"]*?)"/g, (match, p1) => {
        if (!p1.includes('flex-col') && !p1.includes('flex-row')) {
            let updated = p1.replace(/\bflex\b/, 'flex flex-col lg:flex-row');
            return `class="${updated}"`;
        }
        return match;
    });

    content = content.replace(/class="([^"]*?\bflex\b[^"]*?\bgap-6\b[^"]*?)"/g, (match, p1) => {
        if (!p1.includes('flex-col') && !p1.includes('flex-row') && !p1.includes('items-center') && !p1.includes('items-start')) {
            let updated = p1.replace(/\bflex\b/, 'flex flex-col md:flex-row');
            return `class="${updated}"`;
        }
        return match;
    });
    
    // Make headers/steppers responsive
    content = content.replace(/class="flex items-start justify-between mb-8 pb-8 border-b border-gray-100"/g, 'class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 pb-8 gap-6 border-b border-gray-100"');
    content = content.replace(/class="flex items-start justify-between mb-8"/g, 'class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-6"');
    content = content.replace(/class="flex flex-col pl-8"/g, 'class="flex flex-col lg:pl-8 w-full lg:w-auto"');

    // Special custom layout fixes
    content = content.replace(/class="flex gap-4 pb-10"/g, 'class="flex flex-col lg:flex-row gap-4 pb-10"');
    content = content.replace(/class="w-1\/3 border border-gray-100 rounded-xl p-6 shadow-sm bg-\[#FAFAFA\] flex flex-col justify-center"/g, 'class="w-full lg:w-1/3 border border-gray-100 rounded-xl p-6 shadow-sm bg-[#FAFAFA] flex flex-col justify-center"');
    content = content.replace(/id="pass-cards-container" class="flex gap-4 mb-8"/g, 'id="pass-cards-container" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8"');
    content = content.replace(/id="lobby-featured-exhibitors" class="flex gap-4 mb-4"/g, 'id="lobby-featured-exhibitors" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-4"');
    
    // Payment method forms layout
    content = content.replace(/class="flex border border-gray-200 rounded-2xl overflow-hidden bg-white mb-10 shadow-sm min-h-\[400px\]"/g, 'class="flex flex-col md:flex-row border border-gray-200 rounded-2xl overflow-hidden bg-white mb-10 shadow-sm min-h-[400px]"');
    content = content.replace(/class="w-\[320px\] bg-white border-r border-gray-200 flex flex-col"/g, 'class="w-full md:w-[320px] bg-white border-b md:border-b-0 md:border-r border-gray-200 flex flex-col"');
    content = content.replace(/class="flex-1 p-8 flex flex-col bg-\[#FAFAFA\]"/g, 'class="flex-1 p-4 md:p-8 flex flex-col bg-[#FAFAFA]"');

    // Make layout grids responsive (grid-cols-4, 3, 2, 5, 6)
    content = content.replace(/class="grid grid-cols-4 gap-4 pb-20"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-20"');
    content = content.replace(/class="grid grid-cols-4 gap-4"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"');
    content = content.replace(/class="grid grid-cols-4 gap-6"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"');
    content = content.replace(/class="grid grid-cols-4 gap-5"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5"');
    content = content.replace(/class="grid grid-cols-3 gap-6 mb-6"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6"');
    content = content.replace(/class="grid grid-cols-3 gap-y-6 gap-x-4"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4"');
    content = content.replace(/class="grid grid-cols-3 gap-4 mb-6"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6"');
    content = content.replace(/class="grid grid-cols-3 gap-3"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3"');
    content = content.replace(/class="grid grid-cols-2 gap-6 mb-6"/g, 'class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"');
    content = content.replace(/class="grid grid-cols-2 gap-4"/g, 'class="grid grid-cols-1 sm:grid-cols-2 gap-4"');
    content = content.replace(/class="grid grid-cols-2 gap-3 mb-6"/g, 'class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6"');
    content = content.replace(/class="grid grid-cols-5 gap-4 text-left"/g, 'class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 text-left"');
    content = content.replace(/class="grid grid-cols-5 gap-4 mb-10"/g, 'class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-10"');
    content = content.replace(/class="grid grid-cols-6 gap-4"/g, 'class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4"');
    content = content.replace(/class="grid grid-cols-6 gap-3 w-full h-full relative"/g, 'class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 w-full h-full relative"');
    content = content.replace(/class="flex-1 grid grid-cols-2 gap-y-5 gap-x-4 pt-1"/g, 'class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-y-5 gap-x-4 pt-1"');

    // Smart responsive width replacements for any fixed-width containers (width >= 250px)
    content = content.replace(/class="([^"]*?\bw-\[(\d+)px\][^"]*?)"/g, (match, p1, p2) => {
        const width = parseInt(p2);
        if (width >= 250) {
            if (p1.includes('shrink-0') || p1.includes('flex-shrink-0')) {
                if (!p1.includes('lg:w-[')) {
                    let updated = p1.replace(`w-[${p2}px]`, `w-full lg:w-[${p2}px]`);
                    // Adjust top padding if any on desktop
                    updated = updated.replace(/\bpt-\[(\d+)px\]/g, 'lg:pt-[$1px]');
                    return `class="${updated}"`;
                }
            } else {
                if (!p1.includes('max-w-[')) {
                    let updated = p1.replace(`w-[${p2}px]`, `w-full max-w-[${p2}px]`);
                    return `class="${updated}"`;
                }
            }
        }
        return match;
    });

    // Make special case statistic grid flexible inside exhibitor details
    content = content.replace(/class="w-\[450px\] shrink-0 bg-primary-50\/50 rounded-\[24px\] p-6 grid grid-cols-2 gap-6 border border-primary-50"/g, 'class="w-full lg:w-[450px] shrink-0 bg-primary-50/50 rounded-[24px] p-6 grid grid-cols-1 sm:grid-cols-2 gap-6 border border-primary-50"');

    // Strip out fixed minimum-widths that prevent mobile scaling
    content = content.replace(/min-w-\[800px\]/g, 'min-w-0 w-full');
    content = content.replace(/min-w-\[700px\]/g, 'min-w-0 w-full');
    content = content.replace(/min-w-\[650px\]/g, 'min-w-0 w-full');
    content = content.replace(/min-w-\[600px\]/g, 'min-w-0 w-full');
    content = content.replace(/min-w-\[280px\]/g, 'min-w-0 w-full');

    // Header adjustments
    content = content.replace(/px-10 py-5 flex items-center justify-between/g, 'px-4 py-4 md:px-10 md:py-5 flex items-center justify-between');

    // Sidebar and mobile menu toggle visibility breakpoint adjustments
    content = content.replace(/class="hidden md:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"/g, 'class="hidden lg:block h-full flex-shrink-0 z-20 border-r border-gray-100 bg-white"');
    content = content.replace(/class="hidden md:block h-full flex-shrink-0 z-20 shadow-sm bg-white"/g, 'class="hidden lg:block h-full flex-shrink-0 z-20 shadow-sm bg-white"');
    content = content.replace(/class="hidden md:block h-full"/g, 'class="hidden lg:block h-full"');
    content = content.replace(/id="mobile-menu-toggle" class="md:hidden/g, 'id="mobile-menu-toggle" class="lg:hidden');

    fs.writeFileSync(path.join(dir, file), content, 'utf8');
});

console.log('Universal UI & Responsiveness enhancements applied to ' + files.length + ' HTML files.');
