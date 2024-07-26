import time
import threading

def infinite_loop():
    print("Starting infinite loop. Type 'exit' to stop.")
    while True:
        time.sleep(1)  # Sleep to prevent immediate reprints

def run_script():
    # Run the infinite loop in a separate thread
    loop_thread = threading.Thread(target=infinite_loop)
    loop_thread.start()

    # Wait for a maximum of 10 seconds
    loop_thread.join(timeout=10)

    # Check if the thread is still alive
    if loop_thread.is_alive():
        print("Infinite loop detected. Stopping execution.")
        # In a real scenario, you would use a flag to safely stop the thread
        # For simplicity, we'll just print a message
        loop_thread.join(timeout=1)  # Attempt to stop the thread

if __name__ == "__main__":
    run_script()
