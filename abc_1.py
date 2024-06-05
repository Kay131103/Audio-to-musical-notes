"""import sys
import librosa
import numpy as np

def freq_to_note(freq):
    if freq <= 0:
        return "-"  # Handle cases where the frequency is zero or negative

    # Mapping of frequencies to musical notes
    notes = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B']
    A4_freq = 440  # Frequency of A4 (in Hz)

    # Calculate the octave and note index
    note_index = 12 * np.log2(freq / A4_freq) % 12
    octave = int(np.log2(freq / A4_freq) // 1) + 4

    return f"{notes[int(note_index)]}{octave}"

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python script_name.py audio_file.mp3")
        sys.exit(1)

    audio_file = sys.argv[1]

    try:
        # Load the preprocessed audio file
        y, sr = librosa.load(audio_file)

        # Calculate the Short-Time Fourier Transform (STFT) of the audio
        D = librosa.stft(y)

        # Convert amplitude to dB (decibels)
        D_db = librosa.amplitude_to_db(np.abs(D))

        # Find the frequency with the highest magnitude for each time frame
        max_freq_indices = np.argmax(D_db, axis=0)

        # Map frequency indices to corresponding frequencies
        freqs = librosa.fft_frequencies(sr=sr)

        # Extract the dominant frequency for each time frame
        dominant_freqs = freqs[max_freq_indices]

        # Convert frequencies to musical notes
        notes = [freq_to_note(freq) for freq in dominant_freqs]
        # Set the maximum number of notes per line
        notes_per_line = 25
        # Initialize an empty string to store the formatted notes
        notes_paragraph = ""

        # Loop through the notes and add them to the paragraph with line breaks
        for i, note in enumerate(notes, 1):
            notes_paragraph += note
        # Add a line break after every 'notes_per_line' notes, except for the last note
            if i % notes_per_line == 0 and i != len(notes):
                notes_paragraph += "\n"
            else:
                notes_paragraph += " "  # Add a space between notes

# Print the notes paragraph
        
        print(notes_paragraph)
        
    except Exception as e:
     print(f"Error: {e}")"""

import sys
import librosa
import numpy as np

def freq_to_note(freq):
    if freq <= 0:
        return "-"  # Handle cases where the frequency is zero or negative

    # Mapping of frequencies to musical notes
    notes = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B']
    A4_freq = 440  # Frequency of A4 (in Hz)

    # Calculate the octave and note index
    note_index = 12 * np.log2(freq / A4_freq) % 12
    octave = int(np.log2(freq / A4_freq) // 1) + 4

    return f"{notes[int(note_index)]}{octave}"

def generate_notes(audio_file, notes_per_line=25):
    try:
        # Load the preprocessed audio file
        y, sr = librosa.load(audio_file)

        # Calculate the Short-Time Fourier Transform (STFT) of the audio
        D = librosa.stft(y)

        # Convert amplitude to dB (decibels)
        D_db = librosa.amplitude_to_db(np.abs(D))

        # Find the frequency with the highest magnitude for each time frame
        max_freq_indices = np.argmax(D_db, axis=0)

        # Map frequency indices to corresponding frequencies
        freqs = librosa.fft_frequencies(sr=sr)

        # Extract the dominant frequency for each time frame
        dominant_freqs = freqs[max_freq_indices]

        # Convert frequencies to musical notes
        notes = [freq_to_note(freq) for freq in dominant_freqs]

        # Get duration of each time frame
        frame_duration = librosa.samples_to_time(1, sr=sr)

        # Initialize variables for tracking extended notes or pauses
        current_note = None
        notes_count = 0
        notes_paragraph = ""
        time_counter = 0.0

        # Loop through the notes and add them to the paragraph with line breaks
        for i, note in enumerate(notes):
            if note != current_note:
                if current_note is not None:
                    # Add a note or pause to the paragraph
                    if current_note == "-":
                        notes_paragraph += " "  # Add space for a pause
                    else:
                        notes_paragraph += f"{current_note} "  # Add the note with space
                    notes_count += 1

                    # Check if it's time for a line break
                    if notes_count % notes_per_line == 0:
                        notes_paragraph += "\n"

                # Update the current note and reset the time counter
                current_note = note
                time_counter = frame_duration

            else:
                # Increment the time counter
                time_counter += frame_duration

        # Add the last note or pause to the paragraph
        if current_note is not None:
            if current_note == "-":
                notes_paragraph += " "  # Add space for a pause
            else:
                notes_paragraph += f"{current_note} "  # Add the note with space

        # Print the notes paragraph
        print(notes_paragraph)
        
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    
    if len(sys.argv) != 2:
        print("Usage: python script_name.py audio_file.mp3")
        sys.exit(1)

    audio_file = sys.argv[1]
    generate_notes(audio_file)
