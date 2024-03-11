import React from "react";

function Header() {
      return (
    <>
      <header className='bg-transparent h-3 flex items-center justify-between mb-2'>
        {/* Nome del sito */}
        <h1 className='text-lg font-bold text-red-500 mt-1'>Test</h1>

        {/* Links */}
        <nav className='flex space-x-4'>
          <a href="#" className='text-blue-500 hover:text-blue-700'>Link 1</a>
          <a href="#" className='text-blue-500 hover:text-blue-700'>Link 2</a>
          <a href="#" className='text-blue-500 hover:text-blue-700'>Link 3</a>
        </nav>
      </header> 
    </>
  )
}

export default Header;