import React, { useEffect, useState } from 'react';
import Header from './components/Header';
import Card from './components/Card';

function App() {
  const [videoPaths, setVideoPaths] = useState([]);

  useEffect(() => {
    const fetchVideoPaths = async () => {
      const videoFiles = await import.meta.glob('/public/assets/*.mp4');

      

      const paths = Object.keys(videoFiles).map((videoPath) =>
        videoPath.replace('/public', '')
      );
      console.log(paths)
      setVideoPaths(paths);
    };
    fetchVideoPaths();
  }, []);

  return (
    <>
      <Header />
      {videoPaths.map((videoPath, index) => (

        <Card key={index} videoUrl={`${videoPath}`} />
      ))}
    </>
  );
}

export default App;