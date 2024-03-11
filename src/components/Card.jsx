import React, { useEffect, useState } from "react";
import ReactPlayer from "react-player";

function Card({ videoUrl }) {
    console.log('Video URL:', videoUrl);

    return (
        <div className="relative mb-4 w-full aspect-w-16 aspect-h-9 h-screen">
        <ReactPlayer
            url={videoUrl}
            playing
            loop
            muted
            width="100%"
            height="100%"
            className="left-0"
        />

        <div className="absolute top-10 left-4 text-black text-lg font-bold z-1">
            TESTO DI PROVA
        </div>
        </div>
    );
}

export default Card;
